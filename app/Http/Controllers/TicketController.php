<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketMessage as Message;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Return JSON of all tickets
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Return JSON of given ticket
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Save new ticket
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Processes message receipt for given ticket
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Switches given ticket status to 'closed'
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
