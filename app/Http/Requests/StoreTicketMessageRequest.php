<?php

namespace App\Http\Requests;

class StoreTicketMessageRequest extends TicketFormRequest
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
        ];
    }
}
