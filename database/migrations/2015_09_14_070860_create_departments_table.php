<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDepartmentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('short_name')->nullable();
            $table->boolean('academic')->default(false);
            $table->unsignedInteger('head_id')->nullable(); // H.O.D.
            $table->unsignedInteger('school_id');

            $table->json('additional')->default('[]');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->drop();
        });
    }
}
