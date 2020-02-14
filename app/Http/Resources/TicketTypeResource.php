<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\TicketType
 */
class TicketTypeResource extends JsonResource
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
            'id'          => $this->id,
            'description' => $this->description,
            'created_at'  => $this->created_at,
            'created_by'  => UserResource::make($this->whenLoaded('creator')),
            'updated_at'  => $this->updated_at,
            'updated_by'  => UserResource::make($this->whenLoaded('editor')),
            'deleted_at'  => $this->deleted_at,
            'deleted_by'  => UserResource::make($this->whenLoaded('destroyer')),
            'links'       => [
                'show' => [
                    'method' => 'GET',
                    'url'    => route('api.ticket_types.show', $this),
                ],
                'update' => [
                    'method' => 'PUT',
                    'url'    => route('api.ticket_types.update', $this),
                ],
                'delete' => [
                    'method' => 'DELETE',
                    'url'    => route('api.ticket_types.destroy', $this),
                ],
            ],
        ];
    }
}
