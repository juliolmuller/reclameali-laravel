<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest as StoreRequest;
use App\Http\Requests\UpdateUserDataRequest as UpdateDataRequest;
use App\Http\Requests\UpdateUserPasswordRequest as UpdatePasswordRequest;
use App\Http\Resources\User as Resource;
use App\Http\Middleware\OwnDataOnly;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersApiController extends Controller
{
    /**
     * Extract user data from request
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return void
     */
    private function getData($request, User $user)
    {
        $user->role_id = $request->input('role') ?? Role::where('name', 'customer')->first()->id;
        $user->date_of_birth = $request->input('date_of_birth');
        $user->complement = $request->input('complement');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->zip_code = $request->input('zip_code');
        $user->street = $request->input('street');
        $user->number = $request->input('number');
        $user->city_id = $request->input('city');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->cpf = $request->input('cpf');
    }

    /**
     * Extract user password from request
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return void
     */
    private function getPassword($request, User $user)
    {
        $user->password = Hash::make($request->input('password'));
    }

    /**
     * Checks user's over the data being changed, overwriting $user instance if needed
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return bool
     */
    private function checkOwnDataOnly($request, User &$user)
    {
        $checkHeader = !!$request->header(OwnDataOnly::HEADER);

        if ($checkHeader) {
            $user = Auth::user();
        }

        return $checkHeader;
    }

    /**
     * Return JSON of all users
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index()
    {
        return Resource::collection(
            User::withDefault()
                ->whereHas('role', function (Builder $query) {
                    return $query->where('name', '<>', 'customer');
                })
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->paginate()
        );
    }

    /**
     * Return JSON of given user
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Request $request, User $user)
    {
        $this->checkOwnDataOnly($request, $user);

        $user->loadDefault();

        return Resource::make($user);
    }

    /**
     * Save new user
     *
     * @param \App\Http\Requests\StoreUserRequest $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(StoreRequest $request)
    {
        $user = new User();

        $this->getData($request, $user);
        $this->getPassword($request, $user);

        $user->save();
        $user->loadDefault();

        return Resource::make($user);
    }

    /**
     * Update user's data
     *
     * @param \App\Http\Requests\UpdateUserDataRequest $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function updateData(UpdateDataRequest $request, User $user)
    {
        $this->checkOwnDataOnly($request, $user);
        $this->getData($request, $user);

        $user->save();
        $user->loadDefault();

        return Resource::make($user);
    }

    /**
     * Update user's password
     *
     * @param \App\Http\Requests\UpdateUserPasswordRequest $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function udpatePassword(UpdatePasswordRequest $request, User $user)
    {
        $this->checkOwnDataOnly($request, $user);
        $this->getPassword($request, $user);

        $user->save();
        $user->loadDefault();

        return Resource::make($user);
    }

    /**
     * Deletes given user
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Resources\Json\JsonResource
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        $user->loadDefault();

        return Resource::make($user);
    }
}
