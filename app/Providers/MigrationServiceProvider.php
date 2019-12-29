<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class MigrationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blueprint::macro('changesTracking', function (
            string $usersTable = 'users',
            string $usersPrimary = 'id',
            string $fieldType = 'unsignedBigInteger'
        ) {
            $this->timestamp('created_at')->nullable();
            $this->$fieldType('created_by')->nullable();
            $this->timestamp('updated_at')->nullable();
            $this->$fieldType('updated_by')->nullable();
            $this->timestamp('deleted_at')->nullable();
            $this->$fieldType('deleted_by')->nullable();
            $this->foreign('created_by')->references($usersPrimary)->on($usersTable);
            $this->foreign('updated_by')->references($usersPrimary)->on($usersTable);
            $this->foreign('deleted_by')->references($usersPrimary)->on($usersTable);
        });
    }
}
