<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotebooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // id，用户id，笔记本名字，笔记数，创建时间，更新时间，是否被删除，权限
        Schema::create('notebooks', function (Blueprint $table) {
            $table->increments('notebook_id');
            $table->integer('user_id');
            $table->string('notebook_name');
            $table->integer('notes_count')->default(0);
            $table->boolean('is_valid')->default(true);
            $table->enum('permission',['public','protected'])->default('public');
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
        Schema::dropIfExists('notebooks');
    }
}
