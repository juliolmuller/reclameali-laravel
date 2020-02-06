<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketMessage extends JsonResource
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
            'id'      => $this->id,
            'body'    => $this->body,
            'sent_at' => $this->sent_at,
            'sent_by' => User::make($this->whenLoaded('sender')),
        ];
    }
}
