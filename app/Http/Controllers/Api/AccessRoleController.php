<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class AccessRoleController extends Controller
{
    /**
     * Extract attributes from request and save them to the model
     */
    private function save($request, Role $role)
    {
        $role->description = $request->description;
        $role->name = $request->name;
        $role->save();
    }

    /**
     * Return JSON of all roles
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Role::orderBy('name')->paginate(30);
    }

    /**
     * Return JSON of given role
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return $role;
    }

    /**
     * Save new role
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = new Role();
        $this->save($request, $role);
        return $role;
    }

    /**
     * Update existing role
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->save($request, $role);
        return $role;
    }

    /**
     * Deletes given role
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return $role;
    }
}
