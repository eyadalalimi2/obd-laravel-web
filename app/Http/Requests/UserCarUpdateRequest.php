<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCarUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'brand_id'  => 'required|exists:brands,id',
            'model_id'  => 'required|exists:models,id',
            'year'      => 'required|digits:4',
            'car_name'  => 'nullable|string|max:50',
        ];
    }
}
