<?php

use Illuminate\Database\Seeder;

class NoteTagRelationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\NoteTagRelation::class,2)->create();
    }
}
