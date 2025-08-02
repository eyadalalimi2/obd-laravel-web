<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use OpenAI; // OpenAI facade
use App\Models\ObdCode;
use App\Models\ObdCodeTranslation;

class IndexEmbeddings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'embeddings:index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index embeddings for codes and translations';

    /**
     * @var \OpenAI\Client
     */
    protected $openai;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        // تهيئة عميل OpenAI باستخدام facade
        $this->openai = OpenAI::client(config('services.openai.key'));
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Starting embedding indexing...');

        // اجمع جميع الأكواد والترجمات
        $items = ObdCode::all()->concat(ObdCodeTranslation::all());

        foreach ($items as $item) {
            $text = $item->description ?? $item->translated_text;

            try {
                // طلب متجه embedding من OpenAI
                $response = $this->openai
                    ->embeddings()
                    ->create([
                        'model' => 'text-embedding-ada-002',
                        'input' => $text,
                    ]);

                $vector = $response['data'][0]['embedding'] ?? null;

                if ($vector) {
                    // حفظ المتجه في عمود embedding
                    $item->embedding = $vector;
                    $item->save();
                    $this->info("Indexed embedding for ID {$item->id}");
                } else {
                    $this->error("No embedding returned for ID {$item->id}");
                }
            } catch (\Throwable $e) {
                $this->error("Error indexing ID {$item->id}: " . $e->getMessage());
            }
        }

        $this->info('Embedding indexing completed.');
    }
}
