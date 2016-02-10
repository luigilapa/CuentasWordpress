<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(CuentasFacturas\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->userName,
        'email' => $faker->email,
        'type' => 'usuario',
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(CuentasFacturas\Clientes::class, function (Faker\Generator $faker) {
    return [
        'identificacion' =>$faker->unique()->numerify('1#########'),
        'nombres' => $faker->firstName.' '.$faker->firstName,
        'apellidos' => $faker->lastName.' '.$faker->lastName,
        'correo' => $faker->email,
        'direccion' => $faker->address,
        'telefono' => $faker->numerify('02#######'),
    ];
});

$factory->define(CuentasFacturas\Proveedores::class, function (Faker\Generator $faker) {
    return [
        'identificacion' =>$faker->unique()->numerify('1#########'),
        'nombres' => $faker->firstName.' '.$faker->lastName,
        'correo' => $faker->email,
        'direccion' => $faker->address,
        'telefono' => $faker->numerify('02#######'),
    ];
});
