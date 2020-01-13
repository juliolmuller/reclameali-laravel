<?php

namespace App\Http\Requests;

class StoreTicketRequest extends TicketFormRequest
{
    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message' => ['bail', 'required', 'string', 'between:1,255'],
            'product' => ['bail', 'required', 'exists:products,id'],
            'type'    => ['bail', 'required', 'exists:ticket_types,id'],
        ];
    }
}
