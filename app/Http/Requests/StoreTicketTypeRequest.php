<?php

namespace App\Http\Requests;

class StoreTicketTypeRequest extends TicketTypeFormRequest
{

    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => ['bail', 'required', 'string', 'between:1,255', 'unique:ticket_types,description'],
        ];
    }
}
