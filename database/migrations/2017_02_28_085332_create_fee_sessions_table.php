<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeeSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_sessions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable();
            $table->integer('session_id')->unsigned();
            $table->timestamp('started_at');
            $table->timestamp('ended_at');
            $table->boolean('accepting')->default(false);

            // Housekeeping.
            $table->integer('school_id')->unsigned();
            $table->json('additional')->default('{}');
            $table->softDeletes();
            $table->timestamps();

            // Indices & Constraints.
            $table->index('school_id');
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('school_id')->references('id')->on('schools');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_sessions');
    }
}
