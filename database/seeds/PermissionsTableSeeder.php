<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Seed the database table
     *
     * @return void
     */
    public function run()
    {
        $this->seedPermissions();

        $this->seedCustomersPermissions();

        $this->seedAttendantsPermissions();

        $this->seedManagersPermissions();

        $this->seedAdminsPermissions();
    }

    /**
     * Insert permissions' records from existing routes
     *
     * @return void
     */
    private function seedPermissions()
    {
        foreach (Route::getRoutes()->getRoutes() as $route) {

            $name = $route->getName();
            [$controller, $method] = explode('@', $route->getActionName());

            $duplicatePermission = Permission::where(compact('name'))
                ->orWhere(compact('controller', 'method'))
                ->first();

            if (!$duplicatePermission) {
                Permission::create(compact('name', 'controller', 'method'));
            }
        }
    }

    /**
     * Seed customer's permissions
     *
     * @return void
     */
    private function seedCustomersPermissions()
    {
        // TODO: define routes allowed for customers
        Role::where('name', '=', 'customer')->first();
    }

    /**
     * Seed attendant's permissions
     *
     * @return void
     */
    private function seedAttendantsPermissions()
    {
        // TODO: define routes allowed for attendants
        Role::where('name', '=', 'attendant')->first();
    }

    /**
     * Seed manager's permissions
     *
     * @return void
     */
    private function seedManagersPermissions()
    {
        // TODO: define routes allowed for managers
        Role::where('name', '=', 'manager')->first();
    }

    /**
     * Seed admin's permissions
     *
     * @return void
     */
    private function seedAdminsPermissions()
    {
        // TODO: define routes allowed for admins
        Role::where('name', '=', 'admin')->first();
    }

/*
+----------+-----------------------------+-----------------------+--------------------------------------------------------------+------------+
| Method   | URI                         | Name                  | Action                                                       | Middleware |
+----------+-----------------------------+-----------------------+--------------------------------------------------------------+------------+
| GET|HEAD | /                           | index                 | App\Http\Controllers\HomeController@index                    | web        |
| GET|HEAD | api/access-roles            | roles.index           | App\Http\Controllers\Api\AccessRolesApiController@index      | api        |
| POST     | api/access-roles            | roles.store           | App\Http\Controllers\Api\AccessRolesApiController@store      | api        |
| GET|HEAD | api/access-roles/{role}     | roles.show            | App\Http\Controllers\Api\AccessRolesApiController@show       | api        |
| DELETE   | api/access-roles/{role}     | roles.destroy         | App\Http\Controllers\Api\AccessRolesApiController@destroy    | api        |
| PUT      | api/access-roles/{role}     | roles.update          | App\Http\Controllers\Api\AccessRolesApiController@update     | api        |
| GET|HEAD | api/categories              | categories.index      | App\Http\Controllers\Api\CategoriesApiController@index       | api        |
| POST     | api/categories              | categories.store      | App\Http\Controllers\Api\CategoriesApiController@store       | api        |
| GET|HEAD | api/categories/{category}   | categories.show       | App\Http\Controllers\Api\CategoriesApiController@show        | api        |
| PUT      | api/categories/{category}   | categories.update     | App\Http\Controllers\Api\CategoriesApiController@update      | api        |
| DELETE   | api/categories/{category}   | categories.destroy    | App\Http\Controllers\Api\CategoriesApiController@destroy     | api        |
| GET|HEAD | api/location/cities         | cities.index          | App\Http\Controllers\Api\LocationApiController@cities        | api        |
| GET|HEAD | api/location/states         | states.index          | App\Http\Controllers\Api\LocationApiController@states        | api        |
| GET|HEAD | api/location/{state}/cities | cities.filter         | App\Http\Controllers\Api\LocationApiController@citiesByState | api        |
| POST     | api/products                | products.store        | App\Http\Controllers\Api\ProductsApiController@store         | api        |
| GET|HEAD | api/products                | products.index        | App\Http\Controllers\Api\ProductsApiController@index         | api        |
| PUT      | api/products/{product}      | products.update       | App\Http\Controllers\Api\ProductsApiController@update        | api        |
| DELETE   | api/products/{product}      | products.destroy      | App\Http\Controllers\Api\ProductsApiController@destroy       | api        |
| GET|HEAD | api/products/{product}      | products.show         | App\Http\Controllers\Api\ProductsApiController@show          | api        |
| GET|HEAD | api/ticket-status           | ticket-status.index   | App\Http\Controllers\Api\TicketStatusApiController@index     | api        |
| POST     | api/ticket-status           | ticket-status.store   | App\Http\Controllers\Api\TicketStatusApiController@store     | api        |
| GET|HEAD | api/ticket-status/{status}  | ticket-status.show    | App\Http\Controllers\Api\TicketStatusApiController@show      | api        |
| PUT      | api/ticket-status/{status}  | ticket-status.update  | App\Http\Controllers\Api\TicketStatusApiController@update    | api        |
| DELETE   | api/ticket-status/{status}  | ticket-status.destroy | App\Http\Controllers\Api\TicketStatusApiController@destroy   | api        |
| POST     | api/ticket-types            | ticket-types.store    | App\Http\Controllers\Api\TicketTypesApiController@store      | api        |
| GET|HEAD | api/ticket-types            | ticket-types.index    | App\Http\Controllers\Api\TicketTypesApiController@index      | api        |
| DELETE   | api/ticket-types/{type}     | ticket-types.destroy  | App\Http\Controllers\Api\TicketTypesApiController@destroy    | api        |
| PUT      | api/ticket-types/{type}     | ticket-types.update   | App\Http\Controllers\Api\TicketTypesApiController@update     | api        |
| GET|HEAD | api/ticket-types/{type}     | ticket-types.show     | App\Http\Controllers\Api\TicketTypesApiController@show       | api        |
| GET|HEAD | api/tickets                 | tickets.index         | App\Http\Controllers\Api\TicketsApiController@index          | api        |
| POST     | api/tickets                 | tickets.store         | App\Http\Controllers\Api\TicketsApiController@store          | api        |
| PUT      | api/tickets/{ticket}        | tickets.update        | App\Http\Controllers\Api\TicketsApiController@update         | api        |
| PATCH    | api/tickets/{ticket}        | tickets.close         | App\Http\Controllers\Api\TicketsApiController@close          | api        |
| GET|HEAD | api/tickets/{ticket}        | tickets.show          | App\Http\Controllers\Api\TicketsApiController@show           | api        |
| POST     | api/users                   | users.store           | App\Http\Controllers\Api\UsersApiController@store            | api        |
| GET|HEAD | api/users                   | users.index           | App\Http\Controllers\Api\UsersApiController@index            | api        |
| PUT      | api/users/{user}            | users.update-data     | App\Http\Controllers\Api\UsersApiController@updateData       | api        |
| DELETE   | api/users/{user}            | users.destroy         | App\Http\Controllers\Api\UsersApiController@destroy          | api        |
| PATCH    | api/users/{user}            | users.update-password | App\Http\Controllers\Api\UsersApiController@udpatePassword   | api        |
| GET|HEAD | api/users/{user}            | users.show            | App\Http\Controllers\Api\UsersApiController@show             | api        |
| GET|HEAD | home                        | home                  | App\Http\Controllers\HomeController@dashboard                | web,auth   |
| POST     | signin                      | auth.signin           | App\Http\Controllers\AuthController@signin                   | web,guest  |
| POST     | signout                     | auth.signout          | App\Http\Controllers\AuthController@signout                  | web        |
+----------+-----------------------------+-----------------------+--------------------------------------------------------------+------------+
 */
}
