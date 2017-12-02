<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            'user_id' => 7,
            'tag_content' => '很好很好',
            'is_valid' => true
        ]);
    }
}
