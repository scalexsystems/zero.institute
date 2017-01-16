<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('code')->nullable();
            $table->text('description')->nullable();

            $table->unsignedInteger('year_id')->nullable();
            $table->unsignedInteger('semester_id')->nullable();
            $table->unsignedInteger('school_id')->index();
            $table->unsignedInteger('department_id')->nullable();
            $table->unsignedInteger('discipline_id')->nullable();
            $table->unsignedBigInteger('photo_id')->nullable();

            $table->json('additional')->default('{}');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('discipline_id')->references('id')->on('disciplines');
            $table->foreign('photo_id')->references('id')->on('attachments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['photo_id']);
            $table->dropForeign(['discipline_id']);
            $table->dropForeign(['department_id']);
            $table->dropForeign(['school_id']);
            $table->drop();
        });
    }
}
