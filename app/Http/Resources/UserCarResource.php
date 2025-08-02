<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCarResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'brand_id'     => $this->brand_id,
            'brand_name'   => optional($this->brand)->name,
            'model_id'     => $this->model_id,
            'model_name'   => optional($this->model)->name,
            'year'         => $this->year,
            'car_name'     => $this->car_name,
            'created_at'   => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'updated_at'   => $this->updated_at ? $this->updated_at->toDateTimeString() : null,
        ];
    }
}
