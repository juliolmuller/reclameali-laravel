<?php

namespace Tests;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Log;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,
        DatabaseTransactions;

    protected function log($driver, $stack = [])
    {
        $message = $driver;

        if (count($stack)) {
            $message .= ":\n";

            foreach ($stack as $key => $value) {
                $message .= "\t{$key} => {$value}\n";
            }
        }

        Log::debug($message);
    }

    protected function getUser($roleName = null)
    {
        return User::whereHas('role', function (Builder $query) use ($roleName) {

            if ($roleName) {
                $query->where('name', $roleName);
            }

        })->get()->random();
    }
}
