<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest as StoreRequest;
use App\Http\Requests\UpdateRoleRequest as UpdateRequest;
use App\Http\Resources\Role as Resource;
use App\Models\Role;
use Illuminate\Support\Str;

class AccessRolesApiController extends Controller
{
    /**
     * Extract attributes from request and save them to the model
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Role $role
     * @return void
     */
    private function save($request, Role $role)
    {
        $role->description = $request->description;
        $role->name = Str::lower($request->name);

        $role->save();
    }

    /**
     * Return JSON of all roles
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index()
    {
        return Resource::collection(Role::orderBy('name')->paginate());
    }

    /**
     * Return JSON of given role
     *
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Role $role)
    {
        return Resource::make($role);
    }

    /**
     * Persist new role
     *
     * @param \App\Http\Requests\StoreRoleRequest $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(StoreRequest $request)
    {
        $role = new Role();

        $this->save($request, $role);

        return Resource::make($role);
    }

    /**
     * Update existing role
     *
     * @param \App\Http\Requests\UpdateRoleRequest $request
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(UpdateRequest $request, Role $role)
    {
        $this->save($request, $role);

        return Resource::make($role);
    }

    /**
     * Deletes given role
     *
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Resources\Json\JsonResource
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return Resource::make($role);
    }
}
