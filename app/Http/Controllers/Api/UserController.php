<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest as StoreRequest;
use App\Http\Requests\UpdateUserDataRequest as UpdateDataRequest;
use App\Http\Requests\UpdateUserPasswordRequest as UpdatePasswordRequest;
use App\Http\Middleware\OwnDataOnlyMiddleware;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Extract user data from request
     *
     * @return void
     */
    private function getData($request, User $user)
    {
        $user->role_id = $request->role ?? Role::where('name', 'customer')->first()->id;
        $user->date_of_birth = $request->date_of_birth;
        $user->complement = $request->complement;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->zip_code = $request->zip_code;
        $user->street = $request->street;
        $user->number = $request->number;
        $user->city_id = $request->city;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->cpf = $request->cpf;
    }

    /**
     * Extract user password from request
     *
     * @return void
     */
    private function getPassword($request, User $user)
    {
        $user->password = Hash::make($request->password);
    }

    /**
     * Checks user's over the data being changed, overwriting $user instance if needed
     *
     * @return bool
     */
    private function checkOwnDataOnly($request, User &$user)
    {
        $checkHeader = $request->header(OwnDataOnlyMiddleware::HEADER);
        if ($checkHeader) {
            $user = Auth::user();
        }
        return $checkHeader;
    }

    /**
     * Return JSON of all users
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::whereHas('role', fn(Builder $query) => $query->where('name', '<>', 'customer'))
            ->with(['city.state', 'role'])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->paginate(30);
    }

    /**
     * Return JSON of given user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        $this->checkOwnDataOnly($request, $user);
        return $user->load(['city.state', 'role']);
    }

    /**
     * Save new user
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $user = new User();
        $this->getData($request, $user);
        $this->getPassword($request, $user);
        $user->save();
        return $user->load(['city.state', 'role']);
    }

    /**
     * Update user's data
     *
     * @return \Illuminate\Http\Response
     */
    public function updateData(UpdateDataRequest $request, User $user)
    {
        $this->checkOwnDataOnly($request, $user);
        $this->getData($request, $user);
        $user->save();
        return $user->load(['city.state', 'role']);
    }

    /**
     * Update user's password
     *
     * @return \Illuminate\Http\Response
     */
    public function udpatePassword(UpdatePasswordRequest $request, User $user)
    {
        $this->checkOwnDataOnly($request, $user);
        $this->getPassword($request, $user);
        $user->save();
        return $user->load(['city.state', 'role']);
    }

    /**
     * Deletes given user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->load(['city.state', 'role'])->delete();
        return $user;
    }
}
