<?php

namespace App\Http\Controllers;

use App\Models\TicketStatus as Status;
use Illuminate\Http\Request;

class TicketStatusController extends Controller
{
    /**
     * Return JSON of all ticket status
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Return JSON of given ticket status
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Save new ticket status
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update existing ticket status
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        //
    }

    /**
     * Deletes given ticket status
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        //
    }
}
