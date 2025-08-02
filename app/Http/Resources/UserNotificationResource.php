<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserNotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'read_at'     => $this->read_at,
            'created_at'  => $this->created_at,
            'type'        => $this->notification->type,
            'data'        => json_decode($this->notification->data, true),
            'notification'=> [
                'title'   => $this->notification->title,
                'message' => $this->notification->message,
            ],
        ];
    }
}
