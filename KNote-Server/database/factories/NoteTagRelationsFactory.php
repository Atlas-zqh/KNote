<?php
/**
 * Created by PhpStorm.
 * User: keenan
 * Date: 02/12/2017
 * Time: 22:07
 */

use Faker\Generator as Faker;

$factory->define(App\NoteTagRelation::class, function (Faker $faker) {
    return [
        'note_id' => 69,
        'tag_id' => $faker->numberBetween(1,7)
    ];
});