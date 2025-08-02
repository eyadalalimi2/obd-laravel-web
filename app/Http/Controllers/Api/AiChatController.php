<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AiAssistantService;

class AiChatController extends Controller
{
    /**
     * Handle an incoming chat request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Services\AiAssistantService  $ai
     * @return \Illuminate\Http\JsonResponse
     */

    public function interact(Request $request, AiAssistantService $ai)
    {
        $validated = $request->validate([
            'history'         => 'sometimes|array',
            'history.*.role'  => 'required_with:history|string|in:user,assistant,system',
            'history.*.content' => 'required_with:history|string',
            'message'         => 'required|string',
        ]);

        $history = $validated['history'] ?? [];
        $message = $validated['message'];

        $result = $ai->chat($history, $message);

        // أعد كل المفاتيح: reply, history, error
        return response()->json([
            'reply'   => $result['reply'],
            'history' => $result['history'],
            'error'   => $result['error'],
        ]);
    }
}
