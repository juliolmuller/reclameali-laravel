<?php

namespace App\Http\Requests;

class UpdateRoleRequest extends RoleFormRequest
{
    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => ['bail', 'required', 'alpha_dash', 'between:1,10', "unique:access_roles,name,{$this->role->id}"],
            'description' => ['bail', 'nullable', 'string', 'max:255'],
        ];
    }
}
