<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class PlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    public function rules(): array
    {
        // نجلب النموذج المربوط بمعامل {plan} عبر Route facade
        $plan = Route::current()->parameter('plan');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('plans', 'name')->ignore($plan?->id),
            ],
            'price'           => ['required','numeric','min:0'],
            'duration_days'   => ['required','integer','min:0'],
            'features_json'   => ['required','array','min:1'],
            'features_json.*' => ['required','string', Rule::in([
                'SEARCH_CODES','SAVE_CODES','SHARE_CODES','COMPARE_CODES',
                'DIAGNOSIS_HISTORY','OFFLINE_MODE','SYMPTOM_BASED_DIAGNOSIS','SMART_NOTIFICATIONS',
                'PDF_REPORT','TRENDING_CODES_ANALYTICS','VISUAL_COMPONENT_LIBRARY',
                'AI_DIAGNOSTIC_ASSISTANT',
            ])],
            'is_active'       => ['required','boolean'],
        ];
    }
}
