<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //用户（id，用户名，邮箱账号，性别，密码【加密】，头像，
        //笔记本数，总笔记数，关注数，粉丝数，账号是否有效，账号属性，创建于，更新于，token）
        Schema::table('users', function (Blueprint $table) {
            $table->integer('notebooksCount')->default(0);
            $table->integer('notesCount')->default();
            $table->integer('followCount')->default(0);
            $table->integer('fansCount')->default(0);
            $table->enum('permission', ['normal', 'admin'])->default('normal');
            $table->boolean('isValid')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
