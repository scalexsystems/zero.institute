<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('group_user', function (Blueprint $table) {
            $table->unsignedInteger('group_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->index(['group_id', 'user_id']);
            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('group_user', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['group_id']);
            $table->dropIndex(['group_id', 'user_id']);
            $table->drop();
        });
    }
}
