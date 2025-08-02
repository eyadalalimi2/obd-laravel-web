<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->is_admin;
    }

    public function rules()
    {
        return [
            'user_id'    => 'required|exists:users,id',
            'plan_id'    => 'required|exists:plans,id',
            'start_at'   => 'required|date',
            'end_at'     => 'required|date|after_or_equal:start_at',
            'status'     => 'required|in:active,expired,canceled',
            'platform'   => 'required|string|max:20',
            'txn_token'  => 'nullable|string|max:255',
        ];
    }
}
