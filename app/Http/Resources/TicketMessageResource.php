<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\TicketMessage
 */
class TicketMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'      => $this->id,
            'body'    => $this->body,
            'sent_at' => $this->sent_at,
            'sent_by' => UserResource::make($this->whenLoaded('sender')),
        ];
    }
}
