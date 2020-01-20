<?php

namespace App\Http\Requests;

class StoreUserRequest extends UserFormRequest
{
    use UserPasswordRequestTrait, UserDataRequestTrait {
        UserPasswordRequestTrait::rules as passwordRules;
        UserDataRequestTrait::rules as dataRules;
    }

    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules()
    {
        $rules = array_merge(
            $this->passwordRules(),
            $this->dataRules(),
        );
        unset($rules['old_password']);
        return $rules;
    }

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
