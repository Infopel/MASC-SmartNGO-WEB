<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Projects;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Projects::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(5),
        'description' => $faker->text,
        'homepage' => null,
        'is_public' => true,
        'parent_id' => 0+1,
        'author_id' => 1,
        'identifier' => Str::slug($faker->sentence(5)),
        'status' => true,
        'created_on' => now(),
        'updated_on' => now(),
    ];
});
