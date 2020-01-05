<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketTypeRequest as StoreRequest;
use App\Http\Requests\UpdateTicketTypeRequest as UpdateRequest;
use App\Models\TicketType as Type;

class TicketTypeController extends Controller
{
    /**
     * Extract attributes from request and save them to the model
     */
    private function save($request, Type $type)
    {
        $type->description = $request->description;
        $type->save();
    }

    /**
     * Return JSON of all types
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Type::orderBy('description')->paginate(30);
    }

    /**
     * Return JSON of given type
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        return $type;
    }

    /**
     * Save new type
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $type = new Type();
        $this->save($request, $type);
        return $type;
    }

    /**
     * Update existing type
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Type $type)
    {
        $this->save($request, $type);
        return $type;
    }

    /**
     * Deletes given type
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $type->delete();
        return $type;
    }
}
