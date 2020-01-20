<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupCpfRule();
        $this->setupProtectRule();
    }

    /**
     * Defines validation rule for CPF (Brazilian ID)
     *
     * @return void
     */
    private function setupCpfRule()
    {
        Validator::extend('cpf', function ($attribute, $value) {
            if (is_null($value) || strlen($value) !== 11)
                return false;
            foreach ([9, 10] as $factor) {
                $sum = 0;
                for ($i = 0, $div = $factor + 1; $i < $factor; $i++, $div--) {
                    $num = (int) $value[$i];
                    $sum += ($num * $div);
                }
                $rem = 11 - ($sum % 11);
                $dig = ($rem === 10 || $rem === 11) ? 0 : $rem;
                if ($dig != $value[$factor])
                    return false;
            }
            return true;
        });
    }

    /**
     * Defines validation rule for actions which require current user password
     *
     * @return void
     */
    private function setupProtectRule()
    {
        Validator::extend('protect', function ($attribute, $value, $parameters) {
            $user = User::find($parameters[0]);
            return Hash::check($value, $user->password);
        });
    }
}
