<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Role extends JsonResource
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
            'name'        => $this->name,
            'users'       => User::collection($this->whenLoaded('users')),
            'permissions' => $this->whenLoaded('permissions'),
            'created_at'  => $this->created_at,
            'created_by'  => User::make($this->whenLoaded('creator')),
            'updated_at'  => $this->updated_at,
            'updated_by'  => User::make($this->whenLoaded('editor')),
        ];
    }
}
