<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 标签（id，创建用户id，标签内容，是否被删除）

        Schema::create('tags', function (Blueprint $table) {
            $table->increments('tag_id');
            $table->integer('user_id');
            $table->string('tag_content');
            $table->boolean('is_valid')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
    }
}
