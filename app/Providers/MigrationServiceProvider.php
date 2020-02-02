<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class MigrationServiceProvider extends ServiceProvider
{
    /**
     * Add functionality to the Blueprint class instance
     *
     * @return void
     */
    public function boot()
    {
        $this->upUserstamps();
        $this->downUserstamps();
    }

    /**
     * Create a Blueprint method to add userstamps columns
     *
     * @return void
     */
    private function upUserstamps()
    {
        Blueprint::macro('userstamps', function (
            bool $softdeletes = true,
            array $fieldsName = [],
            string $usersTable = 'users',
            string $usersPrimary = 'id',
            string $fieldType = 'unsignedBigInteger'
        ) {
            $fieldsName['created_at'] ??= 'created_at';
            $fieldsName['created_by'] ??= 'created_by';
            $fieldsName['updated_at'] ??= 'updated_at';
            $fieldsName['updated_by'] ??= 'updated_by';
            $fieldsName['deleted_at'] ??= 'deleted_at';
            $fieldsName['deleted_by'] ??= 'deleted_by';

            $this->timestamp($fieldsName['created_at'])->nullable();
            $this->$fieldType($fieldsName['created_by'])->nullable();
            $this->timestamp($fieldsName['updated_at'])->nullable();
            $this->$fieldType($fieldsName['updated_by'])->nullable();

            $this->foreign($fieldsName['created_by'])
                ->references($usersPrimary)
                ->on($usersTable);

            $this->foreign($fieldsName['updated_by'])
                ->references($usersPrimary)
                ->on($usersTable);

            if ($softdeletes) {
                $this->timestamp($fieldsName['deleted_at'])->nullable();
                $this->$fieldType($fieldsName['deleted_by'])->nullable();

                $this->foreign($fieldsName['deleted_by'])
                    ->references($usersPrimary)
                    ->on($usersTable);
            }
        });
    }

    private function downUserstamps()
    {
        Blueprint::macro('dropUserstamps', function (
            bool $softdeletes = true,
            array $fieldsName = []
        ) {
            $fieldsName['created_at'] ??= 'created_at';
            $fieldsName['created_by'] ??= 'created_by';
            $fieldsName['updated_at'] ??= 'updated_at';
            $fieldsName['updated_by'] ??= 'updated_by';
            $fieldsName['deleted_at'] ??= 'deleted_at';
            $fieldsName['deleted_by'] ??= 'deleted_by';

            $this->dropColumn([
                $fieldsName['created_at'],
                $fieldsName['created_by'],
                $fieldsName['updated_at'],
                $fieldsName['updated_by'],
            ]);

            if ($softdeletes) {
                $this->dropColumn([
                    $fieldsName['deleted_at'],
                    $fieldsName['deleted_by'],
                ]);
            }
        });
    }
}
