<?php

namespace App\Http\Requests;

trait UserPasswordRequestTrait
{
    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => ['bail', 'required'],
            'password'     => ['bail', 'required', 'confirmed'],
        ];
    }
}
