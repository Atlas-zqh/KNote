<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 笔记（id，用户id，所属笔记本id，笔记创建时间，笔记最后更新时间，笔记标题，笔记内容，是否被删除，权限）
        Schema::create('notes', function (Blueprint $table) {
            $table->increments('note_id');
            $table->integer('user_id');
            $table->integer('notebook_id');
            $table->string('title');
            $table->string('content');
            $table->boolean('is_valid')->default(true);
            $table->enum('permission',['public','private'])->default('public');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
