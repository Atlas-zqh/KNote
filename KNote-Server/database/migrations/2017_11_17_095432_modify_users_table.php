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
        // 更改字段名
        Schema::table('users', function (Blueprint $table) {
//            $table->renameColumn('notebooksCount', 'notebooks_count');
//            $table->renameColumn('notesCount','notes_count');
//            $table->renameColumn('followCount','follow_count');
//            $table->renameColumn('fansCount','fans_count');
//            $table->renameColumn('isValid','is_valid');
            $table->renameColumn('id','user_id');
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
