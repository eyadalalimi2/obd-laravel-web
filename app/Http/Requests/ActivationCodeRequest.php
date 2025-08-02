<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class ActivationCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    public function rules(): array
    {
        // نجلب النموذج المربوط بمعامل {activation_code}
        $codeModel = Route::current()->parameter('activation_code');

        return [
            'plan_id'    => ['required', 'exists:plans,id'],
            'code'       => [
                'required',
                'string',
                'max:100',
                Rule::unique('activation_codes', 'code')
                    ->ignore($codeModel?->id),
            ],
            'uses_left'  => ['required','integer','min:1'],
            'expires_at' => ['nullable','date','after:now'],
        ];
    }
}
