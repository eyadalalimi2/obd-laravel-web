<?php

namespace App\Services;

use OpenAI;
use Throwable;
use Illuminate\Support\Facades\Log;
use App\Services\ContextRetrievalService;

class AiAssistantService
{
    protected \OpenAI\Client $openai;
    protected ContextRetrievalService $retrieval;

    public function __construct(ContextRetrievalService $retrieval)
    {
        // تهيئة عميل OpenAI باستخدام المفتاح من الإعدادات
        $this->openai    = OpenAI::client(config('services.openai.key'));
        $this->retrieval = $retrieval;
    }

    /**
     * ينشئ تفاعل دردشة AI مع سياق RAG وهيكلة التحليل المطلوبة.
     *
     * @param array  $history  سجل المحادثة السابقة.
     * @param string $message  نص رسالة المستخدم الحالية.
     * @return array           يحتوي على reply و history و error.
     */
    public function chat(array $history, string $message): array
    {
        try {
            // 1. استرجاع السياق
            $contextItems = $this->retrieval->retrieve($message);
            $contextText  = collect($contextItems)
                ->map(fn($item) =>
                    '- [' . ($item->code ?? $item->obd_code_id) . '] '
                    . ($item->description ?? $item->translated_text)
                )
                ->implode("\n");

            // 2. بناء الـ system prompt كقالب عام
            $systemPrompt = <<<TXT
أنت مساعد تشخيص سيارات احترافي. استخدم المعلومات التالية كسياق:
{$contextText}

عند الإجابة أجب دائمًا بهذا الهيكل التفصيلي مع استبدال العناصر بما يناسب:
—
تحليل الذكاء الاصطناعي:
النسبة المحتملة:
- {X%}: {السبب الأول}
- {Y%}: {السبب الثاني}
- {Z%}: {السبب الثالث}

مستوى الخطورة: {منخفض/متوسط/عالي}
نصيحة: {جملة نصيحة قصيرة}

خطوات الإصلاح:
1. {الخطوة الأولى}
2. {الخطوة الثانية}
3. {الخطوة الثالثة}
—
TXT;

            // 3. دمج الرسائل مع history
            $messages = array_merge(
                [['role' => 'system',    'content' => $systemPrompt]],
                array_map(fn($h) => ['role' => $h['role'], 'content' => $h['content']], $history),
                [['role' => 'user',      'content' => $message]]
            );

            // 4. استدعاء نموذج الدردشة
            $response = $this->openai
                ->chat()
                ->create([
                    'model'       => config('services.openai.model'),
                    'messages'    => $messages,
                    'temperature' => config('services.openai.temperature', 0.7),
                ]);

            $reply = $response['choices'][0]['message']['content'] ?? '';

            // 5. بناء السجل الجديد
            $newHistory = array_merge(
                $history,
                [['role' => 'user',      'content' => $message]],
                [['role' => 'assistant', 'content' => $reply]]
            );

            return [
                'reply'   => $reply,
                'history' => $newHistory,
                'error'   => null,
            ];
        } catch (Throwable $e) {
            // سجّل الخطأ الكامل في اللوق
            Log::error('AI Chat error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'history' => $history,
                'message' => $message,
            ]);

            // أعد رسالة الاستثناء الحقيقية مؤقتًا لاختبار السبب
            return [
                'reply'   => null,
                'history' => $history,
                'error'   => $e->getMessage(),
            ];
        }
    }
}
