<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
