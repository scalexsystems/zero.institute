<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id'); // Requester.
            $table->string('tag'); // Request Type.
            $table->jsonb('body'); // Request Body.
            $table->boolean('locked')->default(false); // Request Completed.
            $table->boolean('retry')->default(false); // Request Rejected.
            $table->boolean('status')->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedInteger('school_id');
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['school_id']);
            $table->drop();
        });
    }
}
