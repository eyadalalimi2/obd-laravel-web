<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAiTranslationService
{
    protected $apiKey;
    protected $apiUrl = 'https://api.openai.com/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
    }

    public function translate($text, $targetLanguage)
    {
        $prompt = "Translate the following text to {$targetLanguage}:\n\n{$text}";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl, [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        return $response->json()['choices'][0]['message']['content'] ?? '';
    }
}
