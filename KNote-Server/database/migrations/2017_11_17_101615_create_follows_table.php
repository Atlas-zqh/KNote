<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 关注关系（id，关注者id，被关注者id）
        Schema::create('follows', function (Blueprint $table) {
            $table->increments('id');
            // 关注者id
            $table->integer('follow_user_id');
            // 被关注者id
            $table->integer('followed_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follows');
    }
}
