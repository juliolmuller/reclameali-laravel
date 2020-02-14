<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\User
 */
class UserResource extends JsonResource
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
            'id'            => $this->id,
            'name'          => $this->first_name,
            'last_name'     => $this->last_name,
            'full_name'     => "{$this->first_name} {$this->last_name}",
            'cpf'           => $this->cpf,
            'date_of_birth' => $this->date_of_birth,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'address' => [
                'street'     => $this->street,
                'number'     => $this->number,
                'complement' => $this->complement,
                'city'       => $this->whenLoaded('city'),
                'state'      => $this->whenLoaded('state'),
                'zip_code'   => $this->zip_code,
            ],
            'role'          => $this->whenLoaded('role'),
            'created_at'    => $this->created_at,
            'created_by'    => UserResource::make($this->whenLoaded('creator')),
            'updated_at'    => $this->updated_at,
            'updated_by'    => UserResource::make($this->whenLoaded('editor')),
            'deleted_at'    => $this->deleted_at,
            'deleted_by'    => UserResource::make($this->whenLoaded('destroyer')),
            'links'         => [
                'show' => [
                    'method' => 'GET',
                    'url'    => route('api.users.show', $this),
                ],
                'update' => [
                    'method' => 'PUT',
                    'url'    => route('api.users.update_data', $this),
                ],
                'security' => [
                    'method' => 'PATCH',
                    'url'    => route('api.users.update_password', $this),
                ],
                'delete' => [
                    'method' => 'DELETE',
                    'url'    => route('api.users.destroy', $this),
                ],
            ],
        ];
    }
}
