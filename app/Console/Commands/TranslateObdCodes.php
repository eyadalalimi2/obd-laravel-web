<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ObdCode;
use App\Models\ObdCodeTranslation;
use App\Models\Language;
use App\Services\OpenAiTranslationService;

class TranslateObdCodes extends Command
{
    protected $signature = 'obd:translate {lang_code}';
    protected $description = 'Translate all OBD codes to the specified language';

    public function handle()
    {
        $langCode = $this->argument('lang_code');
        $language = Language::where('code', $langCode)->first();

        if (!$language) {
            $this->error('Language not found.');
            return;
        }

        $translator = new OpenAiTranslationService();
        $codes = ObdCode::all();

        foreach ($codes as $code) {
            $this->info("Translating code: {$code->code}");

            $fields = [
                'title'       => $translator->translate($code->title, $langCode),
                'description' => $translator->translate($code->description, $langCode),
                'symptoms'    => $translator->translate($code->symptoms, $langCode),
                'causes'      => $translator->translate($code->causes, $langCode),
                'solutions'   => $translator->translate($code->solutions, $langCode),
                'diagnosis'   => $translator->translate($code->diagnosis, $langCode),
                'severity'    => $code->severity,
                'category'    => $code->category,
            ];

            ObdCodeTranslation::updateOrCreate(
                ['obd_code_id' => $code->id, 'language_code' => $langCode],
                $fields
            );
        }

        $this->info('Translation completed successfully.');
    }
}
