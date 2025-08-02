<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'user'       => [
                'id'    => $this->user->id,
                'name'  => $this->user->name,
                'email' => $this->user->email,
            ],
            'plan'       => [
                'id'            => $this->plan->id,
                'name'          => $this->plan->name,
                'price'         => $this->plan->price,
                'duration_days' => $this->plan->duration_days,
                'features'      => $this->plan->features_json, // or ->features if accessor
                'is_active'     => $this->plan->is_active,
            ],
            'start_at'   => optional($this->start_at)->toDateTimeString(),
            'end_at'     => optional($this->end_at)->toDateTimeString(),
            'status'     => $this->status,
            'platform'   => $this->platform,
            'txn_token'  => $this->txn_token,
            'created_at' => optional($this->created_at)->toDateTimeString(),
            'updated_at' => optional($this->updated_at)->toDateTimeString(),
        ];
    }
}
