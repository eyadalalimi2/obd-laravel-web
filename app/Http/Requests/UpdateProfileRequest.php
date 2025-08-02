<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'username'      => ['required','string','max:255', Rule::unique('users','username')->ignore(auth()->id())],
            'email'         => ['required','email', Rule::unique('users','email')->ignore(auth()->id())],
            'phone'         => ['nullable','string','max:255'],
            'job_title'     => ['nullable','string','max:255'],
            'profile_image' => ['nullable','image','max:2048'],
            'password'      => ['nullable','string','min:8','confirmed'],
        ];
    }
}