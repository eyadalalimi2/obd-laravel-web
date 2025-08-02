<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ObdCodeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'code'        => $this->code,
            'title'       => $this->title,
            'description' => $this->description,
            'symptoms'    => $this->symptoms,
            'causes'      => $this->causes,
            'solutions'   => $this->solutions,
            'severity'    => $this->severity,
            'diagnosis'   => $this->diagnosis,
            'category'    => $this->category,
            'image'       => $this->image,
            'lang'        => $this->lang,
            'source_url'  => $this->source_url,
            'status'      => $this->status,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}
