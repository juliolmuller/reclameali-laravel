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
        $userId = $this->user->id ?? '';
        return [
            'old_password' => ['bail', 'required', "protect:{$userId}"],
            'password'     => ['bail', 'required', 'confirmed', 'min:8'],
        ];
    }
}
