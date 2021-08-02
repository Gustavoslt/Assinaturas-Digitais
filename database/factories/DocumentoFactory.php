<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Documento;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Documento::class, function (Faker $faker) {
    return [
        'nome' => $faker->name,
        'assinante' => $faker->name,
        'cpf' => $faker->name,
        'num_inscricao' => Str::random(5),
        'status' => 'Criado',
    ];
});
