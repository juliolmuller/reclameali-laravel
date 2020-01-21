<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Middleware\OwnDataOnlyMiddleware;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\StoreTicketMessageRequest;
use App\Models\Ticket;
use App\Models\TicketStatus;
use Illuminate\Http\Request;

class TicketsApiController extends Controller
{
    /**
     * Return JSON of all tickets
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->header(OwnDataOnlyMiddleware::HEADER)) {
            $tickets = Ticket::with(['status', 'type', 'product', 'creator', 'editor', 'destroyer'])
                ->where('created_by', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->paginate(30);
        } else {
            $tickets = Ticket::with(['status', 'type', 'product', 'creator', 'editor', 'destroyer'])
                ->orderBy('created_at', 'desc')
                ->paginate(30);
        }
        return $tickets;
    }

    /**
     * Return JSON of given ticket
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Ticket $ticket)
    {
        if ($request->header(OwnDataOnlyMiddleware::HEADER) && auth()->user()->id !== $ticket->created_by) {
            abort(403);
        }
        return $ticket->load(['status', 'type', 'product', 'messages', 'creator', 'editor', 'destroyer']);
    }

    /**
     * Save new ticket
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create([
            'status_id'  => TicketStatus::where('name', 'OPEN')->first()->id,
            'product_id' => $request->product,
            'type_id'    => $request->type,
        ]);
        $ticket->messages()->create([
            'body' => $request->message,
        ]);
        return $ticket->load(['status', 'type', 'product', 'messages', 'creator', 'editor', 'destroyer']);
    }

    /**
     * Processes message receipt for given ticket
     *
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTicketMessageRequest $request, Ticket $ticket)
    {
        if ($request->header(OwnDataOnlyMiddleware::HEADER) && auth()->user()->id !== $ticket->created_by) {
            abort(403);
        }
        $ticket->messages()->create([
            'body' => $request->message,
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
        $ticket->status_id = TicketStatus::where('name', 'CLOSED')->first()->id;
        $ticket->save();
        return $ticket->load(['status', 'type', 'product', 'messages', 'creator', 'editor', 'destroyer']);
    }
}
