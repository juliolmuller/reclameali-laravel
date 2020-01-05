<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class TicketStatusFormRequest extends FormRequest
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
            'name'        => 'Nome',
            'description' => 'Descrição',
        ];
    }

    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public abstract function rules();
}
