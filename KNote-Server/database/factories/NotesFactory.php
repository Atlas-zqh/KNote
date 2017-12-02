<?php
/**
 * Created by PhpStorm.
 * User: keenan
 * Date: 02/12/2017
 * Time: 21:53
 */

use Faker\Generator as Faker;

$factory->define(App\Note::class, function (Faker $faker) {
    return [
        'user_id' => 7,
        'notebook_id' => 8,
        'title' => $faker->monthName,
        'content' => $faker->paragraph,
        'is_valid' => true,
        'permission' => 'public'
    ];
});