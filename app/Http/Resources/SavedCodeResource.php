<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SavedCodeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'saved_at' => $this->saved_at,
            'obd_code' => [
                'id' => $this->obdCode->id,
                'code' => $this->obdCode->code,
                'title' => $this->obdCode->title,
                'category' => $this->obdCode->category,
            ],
        ];
    }
}
