<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCarUpdateRequest extends FormRequest
{
    public function authorize()
    {
        // يمكن تحسينها بالتحقق من أن السيارة فعلاً ملك للمستخدم، هنا السماح لمن هو مسجل فقط
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
