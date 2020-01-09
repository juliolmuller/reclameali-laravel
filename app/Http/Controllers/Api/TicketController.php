<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
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
        return Ticket::with(['status', 'type', 'product', 'creator', 'editor', 'destroyer'])
            ->orderBy('created_at', 'desc')
            ->paginate(30);
    }

    /**
     * Return JSON of given ticket
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        return $ticket->load(['status', 'type', 'product', 'messages', 'creator', 'editor', 'destroyer']);
    }

    /**
     * Save new ticket
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ticket = Ticket::create([
            'product_id' => $request->product,
            'status_id'  => $request->status,
            'type_id'    => $request->type,
        ]);
        $ticket->messages()->create([
            'body'      => $request->message,
        ]);
        return $ticket->load(['status', 'type', 'product', 'messages', 'creator', 'editor', 'destroyer']);
    }

    /**
     * Processes message receipt for given ticket
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        $ticket->messages()->create([
            'body'      => $request->message,
        ]);
        return $ticket->load(['status', 'type', 'product', 'messages', 'creator', 'editor', 'destroyer']);
    }

    /**
     * Switches given ticket status to 'closed'
     *
     * @return \Illuminate\Http\Response
     */
    public function close(Ticket $ticket)
    {
        $ticket->closed_at = now();
        $ticket->save();
        return $ticket->load(['status', 'type', 'product', 'messages', 'creator', 'editor', 'destroyer']);
    }
}
