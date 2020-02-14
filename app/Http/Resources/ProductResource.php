<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Product
 */
class ProductResource extends JsonResource
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
            'weight'      => $this->weight,
            'utc'         => $this->utc,
            'ean'         => $this->ean,
            'category'    => CategoryResource::make($this->whenLoaded('category')),
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
                    'url'    => route('api.products.show', $this),
                ],
                'update' => [
                    'method' => 'PUT',
                    'url'    => route('api.products.update', $this),
                ],
                'delete' => [
                    'method' => 'DELETE',
                    'url'    => route('api.products.destroy', $this),
                ],
            ],
        ];
    }
}
