<?php
/**
 * Created by PhpStorm.
 * User: keenan
 * Date: 02/12/2017
 * Time: 21:40
 */

use Faker\Generator as Faker;

$factory->define(App\Notebook::class, function (Faker $faker) {
    return [
        'user_id' => 7,
        'notebook_name' => $faker->title,
        'notes_count' => 0,
        'is_valid' => true,
        'permission' => 'public'
    ];
});