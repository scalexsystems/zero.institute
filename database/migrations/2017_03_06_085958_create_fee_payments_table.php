<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('paid')->default(false);
            $table->integer('amount');
            $table->timestamp('deadline')->nullable();
            $table->integer('fee_template_id')->unsigned()->nullable();
            $table->integer('fee_session_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->integer('school_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->index('school_id');
            $table->index('student_id');
            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('fee_session_id')->references('id')->on('fee_sessions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_payments');
    }
}
