<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Ticket extends JsonResource
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
            'id'          => $this->id,
            'product'     => User::make($this->whenLoaded('product')),
            'status'      => User::make($this->whenLoaded('status')),
            'type'        => User::make($this->whenLoaded('type')),
            'messages'    => TicketMessage::collection($this->whenLoaded('messages')),
            'created_at'  => $this->created_at,
            'created_by'  => User::make($this->whenLoaded('creator')),
            'closed_at'   => $this->closed_at,
            'closed_by'   => $this->when(!!$this->closed_at, User::make($this->whenLoaded('editor'))),
            'updated_at'  => $this->updated_at,
            'updated_by'  => User::make($this->whenLoaded('editor')),
        ];
    }
}
