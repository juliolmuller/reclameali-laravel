<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketStatusRequest as StoreRequest;
use App\Http\Requests\UpdateTicketStatusRequest as UpdateRequest;
use App\Http\Resources\TicketStatusResource as Resource;
use App\Models\TicketStatus as Status;
use Illuminate\Support\Str;

class TicketStatusApiController extends Controller
{
    /**
     * Extract attributes from request and save them to the model
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \App\Models\TicketStatus $status
     * @return void
     */
    private function save($request, Status $status)
    {
        $status->description = $request->input('description');
        $status->name = Str::upper($request->name);

        $status->save();
    }

    /**
     * Return JSON of all status
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index()
    {
        return Resource::collection(
            Status::withDefault()
                ->orderBy('name')
                ->paginate()
        );
    }

    /**
     * Return JSON of given status
     *
     * @param \App\Models\TicketStatus $status
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Status $status)
    {
        $status->loadDefault();

        return Resource::make($status);
    }

    /**
     * Save new status
     *
     * @param \App\Http\Requests\StoreTicketStatusRequest $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(StoreRequest $request)
    {
        $status = new Status();

        $this->save($request, $status);

        $status->loadDefault();

        return Resource::make($status);
    }

    /**
     * Update existing status
     *
     * @param \App\Http\Requests\UpdateTicketStatusRequest $request
     * @param \App\Models\TicketStatus $status
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(UpdateRequest $request, Status $status)
    {
        $this->save($request, $status);

        $status->loadDefault();

        return Resource::make($status);
    }

    /**
     * Deletes given status
     *
     * @param \App\Models\TicketStatus $status
     * @return \Illuminate\Http\Resources\Json\JsonResource
     * @throws \Exception
     */
    public function destroy(Status $status)
    {
        $status->delete();
        $status->loadDefault();

        return Resource::make($status);
    }
}
