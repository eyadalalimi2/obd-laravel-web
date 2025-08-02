<?php

namespace App\Services;

use OpenAI;
use Throwable;
use Illuminate\Support\Facades\Log;
use App\Models\ObdCode;
use App\Models\ObdCodeTranslation;

class ContextRetrievalService
{
    protected \OpenAI\Client $openai;

    public function __construct()
    {
        $this->openai = OpenAI::client(config('services.openai.key'));
    }

    /**
     * يسترجع أعلى $limit نتائج تشابه بين embedding الاستعلام
     * وembeddings المخزنة في جداول الأكواد والترجمات،
     * محسوبة في PHP لتجنب أخطاء البناء في MySQL/MariaDB.
     *
     * @param string $query
     * @param int    $limit
     * @return array
     */
    public function retrieve(string $query, int $limit = 5): array
    {
        // 1. احصل على embedding للاستعلام
        try {
            $embRes = $this->openai
                ->embeddings()
                ->create([
                    'model' => config('services.openai.embedding_model', 'text-embedding-ada-002'),
                    'input' => $query,
                ]);
            $qVector = $embRes['data'][0]['embedding'] ?? [];
        } catch (Throwable $e) {
            Log::error('Embedding error: ' . $e->getMessage());
            return [];
        }

        if (empty($qVector)) {
            return [];
        }

        // 2. جلب كل الأكواد والترجمات التي لديها embedding
        $codes = ObdCode::whereNotNull('embedding')->get(['id', 'code', 'description', 'embedding']);
        $translations = ObdCodeTranslation::whereNotNull('embedding')
            ->get(['id', 'obd_code_id', 'description as translated_text', 'embedding']);

        // 3. حساب التشابه في PHP
        $scored = [];
        foreach ($codes as $code) {
            $sim = $this->cosineSimilarity($qVector, $code->embedding);
            $scored[] = [
                'type'        => 'code',
                'id'          => $code->id,
                'code'        => $code->code,
                'description' => $code->description,
                'similarity'  => $sim,
            ];
        }
        foreach ($translations as $trans) {
            $sim = $this->cosineSimilarity($qVector, $trans->embedding);
            $scored[] = [
                'type'            => 'translation',
                'id'              => $trans->id,
                'obd_code_id'     => $trans->obd_code_id,
                'translated_text' => $trans->translated_text,
                'similarity'      => $sim,
            ];
        }

        // 4. ترتيب النتائج وأخذ أعلى $limit
        usort($scored, fn($a, $b) => $b['similarity'] <=> $a['similarity']);

        return array_slice($scored, 0, $limit);
    }

    /**
     * حساب Cosine Similarity بين متجهين.
     *
     * @param array $a
     * @param array $b
     * @return float
     */
    private function cosineSimilarity(array $a, array $b): float
    {
        $dot = 0.0;
        $normA = 0.0;
        $normB = 0.0;
        $len = min(count($a), count($b));

        for ($i = 0; $i < $len; $i++) {
            $dot += $a[$i] * $b[$i];
            $normA += $a[$i] ** 2;
            $normB += $b[$i] ** 2;
        }

        return ($normA > 0 && $normB > 0)
            ? $dot / (sqrt($normA) * sqrt($normB))
            : 0.0;
    }
}
