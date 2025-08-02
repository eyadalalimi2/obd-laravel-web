<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
            // إذا احتجت إضافة الموديلات يمكنك ذلك هنا كمصفوفة
            // 'models' => ModelResource::collection($this->whenLoaded('models')),
        ];
    }
}
