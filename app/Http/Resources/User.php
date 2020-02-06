<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array
     *
     * @param  \Illuminate\Http\Request $request
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
            'created_by'    => User::make($this->whenLoaded('creator')),
            'updated_at'    => $this->updated_at,
            'updated_by'    => User::make($this->whenLoaded('editor')),
            'deleted_at'    => $this->deleted_at,
            'deleted_by'    => User::make($this->whenLoaded('destroyer')),
        ];
    }
}
