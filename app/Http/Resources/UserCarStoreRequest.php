<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCarStoreRequest extends FormRequest
{
    public function authorize()
    {
        // تأكيد أن المستخدم مسجل الدخول
        return auth()->check();
    }

    public function rules()
    {
        return [
            'brand_id' => 'required|exists:brands,id',
            'model_id' => 'required|exists:models,id',
            'year' => 'required|digits:4',
            'car_name' => 'nullable|string|max:50',
        ];
    }

    public function messages()
    {
        return [
            'brand_id.required' => 'يجب اختيار الشركة المصنعة.',
            'brand_id.exists'   => 'الشركة غير موجودة.',
            'model_id.required' => 'يجب اختيار الموديل.',
            'model_id.exists'   => 'الموديل غير موجود.',
            'year.required'     => 'يجب اختيار سنة الإنتاج.',
            'year.digits'       => 'سنة الإنتاج يجب أن تكون 4 أرقام.',
            'car_name.max'      => 'اسم السيارة يجب ألا يزيد عن 50 حرفاً.',
        ];
    }
}
