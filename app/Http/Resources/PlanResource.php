<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'price'         => $this->price,
            'duration_days' => $this->duration_days,
            'features'      => $this->features_json, // مصفوفة من الميزات
            'is_active'     => (bool)$this->is_active,
        ];
    }
}
