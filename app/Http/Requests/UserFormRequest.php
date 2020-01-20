<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Set attributes label to be displaied to the user
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'first_name'            => 'Nome',
            'last_name'             => 'Sobrenome',
            'cpf'                   => 'CPF',
            'date_of_birth'         => 'Data de Nascimento',
            'phone'                 => 'Telefone',
            'email'                 => 'Email',
            'zip_code'              => 'CEP',
            'street'                => 'Rua',
            'number'                => 'Número',
            'complement'            => 'Complemento',
            'state'                 => 'Estado',
            'city'                  => 'Cidade',
            'role'                  => 'Perfil de Acesso',
            'old_password'          => 'Senha Atual',
            'password'              => 'Nova Senha',
            'password_confirmation' => 'Confirmar Senha',
        ];
    }

    /**
     * Override default error messages
     *
     * @return array
     */
//    public function messages()
//    {
//        return [
//            'regex'            => 'O campo <u>:attribute</u> deve conter apenas letras, hífen e/ou espaços.',
//            'before_or_equal'  => 'O usuário deve ser maior de 18 anos para se cadastrar.',
//            'confirmed'        => 'Repita o valor da nova senha no campo correspondente.',
//        ];
//    }

    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public abstract function rules();
}
