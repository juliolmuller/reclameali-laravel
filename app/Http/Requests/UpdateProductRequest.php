<?php

namespace App\Http\Requests;

class UpdateProductRequest extends ProductFormRequest
{
    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'bail|required|string|between:3,255|unique:products,name,' . $this->product->id,
            'description' => 'bail|nullable|string|max:5000',
            'weight'      => 'bail|nullable|numeric|min:0',
            'category'    => 'bail|required|exists:categories,id',
            'utc'         => 'bail|required|digits:12|unique:products,utc,' . $this->product->id,
            'ean'         => 'bail|nullable|digits:13|unique:products,ean,' . $this->product->id,
        ];
    }
}
