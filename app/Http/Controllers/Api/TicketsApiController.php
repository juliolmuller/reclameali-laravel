<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Middleware\OwnDataOnly;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\StoreTicketMessageRequest;
use App\Http\Resources\Ticket as Resource;
use App\Models\Ticket;
use App\Models\TicketStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketsApiController extends Controller
{
    /**
     * Return JSON of all tickets
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index(Request $request)
    {
        return Resource::collection(
            Ticket::withDefault()
                ->when($request->header(OwnDataOnly::HEADER), function (Builder $query) {
                    return $query->where('created_by', Auth::user()->id);
                })
                ->orderByDesc('created_at')
                ->paginate()
        );
    }

    /**
     * Return JSON of given ticket
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Request $request, Ticket $ticket)
    {
        if ($request->header(OwnDataOnly::HEADER) && Auth::user()->id !== $ticket->created_by) {
            abort(403);
        }

        $ticket->loadDefault(['messages']);

        return Resource::make($ticket);
    }

    /**
     * Save new ticket
     *
     * @param \App\Http\Requests\StoreTicketRequest $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create([
            'status_id'  => TicketStatus::where('name', 'OPEN')->first()->id,
            'product_id' => $request->input('product'),
            'type_id'    => $request->input('type'),
        ]);

        $ticket->messages()->create([
            'body' => $request->input('message'),
        ]);

        $ticket->loadDefault(['messages']);

        return Resource::make($ticket);
    }

    /**
     * Processes message receipt for given ticket
     *
     * @param \App\Http\Requests\StoreTicketMessageRequest $request
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(StoreTicketMessageRequest $request, Ticket $ticket)
    {
        if ($request->header(OwnDataOnly::HEADER) && Auth::user()->id !== $ticket->created_by) {
            abort(404);
        }

        $ticket->messages()->create([
            'body' => $request->input('message'),
        ]);

        $ticket->loadDefault(['messages']);

        return Resource::make($ticket);
    }

    /**
     * Switches given ticket status to 'closed'
     *
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function close(Ticket $ticket)
    {
        $ticket->closed_at = now();
        $ticket->status_id = TicketStatus::where('name', 'CLOSED')->first()->id;

        $ticket->save();
        $ticket->loadDefault(['messages']);

        return Resource::make($ticket);
    }
}
