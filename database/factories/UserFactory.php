<?php

use App\Models\City;
use App\Models\Role;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    return [
        'first_name'        => $firstName,
        'last_name'         => $lastName,
        'cpf'               => $faker->cpf,
        'date_of_birth'     => $faker->date('Y-m-d', '-18 years'),
        'phone'             => $faker->randomElement([null, $faker->numerify('##9########'), $faker->numerify('##3#######')]),
        'email'             => Str::lower("{$firstName}.{$lastName}") . '@email.com',
        'email_verified_at' => $faker->dateTime(),
        'street'            => $faker->optional(0.7)->randomElement([$faker->randomElement(['R.', 'Rua', 'Av.', 'Avenida', 'Alameda']) . ' ' . $faker->streetName]),
        'number'            => $faker->optional(0.7)->buildingNumber,
        'zip_code'          => $faker->optional(0.7)->numerify(str_repeat('#', 8)),
        'complement'        => $faker->optional(0.7)->secondaryAddress,
        'city_id'           => $faker->numberBetween(0, 4) ? City::all()->random() : null,
        'role_id'           => Role::all()->random(),
        'password'          => Hash::make($faker->password(8)),
        'remember_token'    => Str::random(10),
    ];
});
