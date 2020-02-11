<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketTypeRequest as StoreRequest;
use App\Http\Requests\UpdateTicketTypeRequest as UpdateRequest;
use App\Http\Resources\TicketType as Resource;
use App\Models\TicketType as Type;

class TicketTypesApiController extends Controller
{
    /**
     * Extract attributes from request and save them to the model
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \App\Models\TicketType $type
     * @return void
     */
    private function save($request, Type $type)
    {
        $type->description = $request->input('description');

        $type->save();
    }

    /**
     * Return JSON of all types
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index()
    {
        return Resource::collection(
            Type::withDefault()
                ->orderBy('description')
                ->paginate()
        );
    }

    /**
     * Return JSON of given type
     *
     * @param \App\Models\TicketType $type
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Type $type)
    {
        $type->loadDefault();

        return Resource::make($type);
    }

    /**
     * Save new type
     *
     * @param \App\Http\Requests\StoreTicketTypeRequest $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(StoreRequest $request)
    {
        $type = new Type();

        $this->save($request, $type);

        $type->loadDefault();

        return Resource::make($type);
    }

    /**
     * Update existing type
     *
     * @param \App\Http\Requests\UpdateTicketTypeRequest $request
     * @param \App\Models\TicketType $type
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(UpdateRequest $request, Type $type)
    {
        $this->save($request, $type);

        $type->loadDefault();

        return Resource::make($type);
    }

    /**
     * Deletes given type
     *
     * @param \App\Models\TicketType $type
     * @return \Illuminate\Http\Resources\Json\JsonResource
     * @throws \Exception
     */
    public function destroy(Type $type)
    {
        $type->delete();
        $type->loadDefault();

        return Resource::make($type);
    }
}
