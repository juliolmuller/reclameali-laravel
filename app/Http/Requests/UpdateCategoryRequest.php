<?php

namespace App\Http\Requests;

class UpdateCategoryRequest extends CategoryFormRequest
{
    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['bail', 'required', 'string', 'between:3,50', "unique:categories,name,{$this->category->id}"],
        ];
    }
}
