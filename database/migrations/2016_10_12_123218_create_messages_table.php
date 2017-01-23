<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->longText('content')->nullable();
            $table->unsignedInteger('sender_id');
            $table->morphs('receiver');
            $table->unsignedInteger('intended_for')->nullable();
            $table->timestamp('read_at')->nullable();

            $table->json('additional')->default('[]');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('intended_for')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['intended_for']);
            $table->dropForeign(['sender_id']);
            $table->drop();
        });
    }
}
