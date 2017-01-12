<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseConstraintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_constraints', function (Blueprint $table) {
            $table->increments('id');
            $table->string('constraint_type');
            $table->unsignedInteger('constraint_id')->nullable();
            $table->unsignedInteger('course_id');
            $table->json('additional')->default('{}');
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
