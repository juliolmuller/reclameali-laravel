<?php

namespace App\Http\Requests;

trait UserDataRequestTrait
{
    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules()
    {
        $exception = $this->isMethod('POST') ? '' : ",{$this->user->id}";
        return [
            'first_name'    => ['bail', 'required', 'string', 'between:1,30', 'regex:/^[A-Za-zÀ-ÖØ-öø-ÿ\- ]+$/'],
            'last_name'     => ['bail', 'required', 'string', 'between:1,150', 'regex:/^[A-Za-zÀ-ÖØ-öø-ÿ\- ]+$/'],
            'cpf'           => ['bail', 'required', 'integer', 'cpf', 'digits:11', "unique:users,cpf{$exception}"],
            'date_of_birth' => ['bail', 'required', 'before_or_equal:-18 years'],
            'email'         => ['bail', 'required', 'email', "unique:users,email{$exception}"],
            'phone'         => ['bail', 'nullable', 'integer', 'digits_between:10,11'],
            'zip_code'      => ['bail', 'nullable', 'integer', 'digits:8'],
            'street'        => ['bail', 'nullable', 'string', 'max:255'],
            'number'        => ['bail', 'nullable', 'integer', 'min:0'],
            'complement'    => ['bail', 'nullable', 'string', 'max:20'],
            'state'         => ['bail', 'nullable', 'exists:states,id'],
            'city'          => ['bail', 'nullable', 'exists:cities,id'],
            'role'          => ['bail', 'nullable', 'exists:access_roles,id'],
        ];
    }
}
