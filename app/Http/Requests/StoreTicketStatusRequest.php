<?php

namespace App\Http\Requests;

class StoreTicketStatusRequest extends TicketStatusFormRequest
{

    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'bail|required|alpha_dash|between:1,30|unique:ticket_status,name',
            'description' => 'bail|nullable|string|max:255',
        ];
    }
}
