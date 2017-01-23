<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGuardiansTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guardians', function (Blueprint $table) {
            $table->increments('id');

            // Basic Information
            $table->unsignedBigInteger('photo_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('category')->nullable();
            $table->string('religion')->nullable();
            $table->string('language')->nullable();
            $table->string('passport')->nullable();
            $table->string('govt_id')->nullable();

            // Personal Information
            $table->string('phone')->nullable();
            $table->float('income')->default(0.0)->nullable();
            $table->unsignedInteger('address_id')->nullable();

            // Medical Information
            $table->boolean('is_disabled')->default(false)->nullable();
            $table->string('disability')->nullable();
            $table->string('disease')->nullable();
            $table->string('allergy')->nullable();
            $table->string('visible_marks')->nullable();
            $table->string('food_habit')->nullable();
            $table->text('medical_remarks')->nullable();

            // Maintenance Information
            $table->boolean('archived')->default(false);
            $table->text('remarks')->nullable();
            $table->unsignedInteger('school_id')->index();


            $table->json('additional')->default('[]');
            $table->softDeletes();
            $table->timestamps();

            // Constraints
            $table->foreign('photo_id')->references('id')->on('attachments');
            $table->foreign('address_id')->references('id')->on('addresses');
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
        Schema::table('guardians', function (Blueprint $table) {
            $table->dropForeign(['photo_id']);
            $table->dropForeign(['address_id']);
            $table->dropForeign(['school_id']);
            $table->drop();
        });
    }
}
