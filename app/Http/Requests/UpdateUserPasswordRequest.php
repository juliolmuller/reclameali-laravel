<?php

namespace App\Http\Requests;

class UpdateUserPasswordRequest extends UserFormRequest
{
    use UserPasswordRequestTrait;

    /**
     * Override default error messages
     *
     * @return array
     */
    public function messages()
    {
        $messages = parent::messages();
        $messages['confirmed'] = 'Repita o valor da nova senha no campo correspondente.';
        return $messages;
    }
}
