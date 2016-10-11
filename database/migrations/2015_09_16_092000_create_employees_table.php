<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
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
            $table->string('nationality')->nullable();
            $table->string('passport')->nullable();
            $table->string('govt_id')->nullable();
            // Related to school
            $table->string('uid');
            $table->date('date_of_joining')->nullable();
            $table->string('job_title')->nullable();
            $table->unsignedInteger('department_id')->nullable();
            $table->string('biometric_id')->nullable();
            // Qualification Details
            $table->json('education')->nullable();
            // Past Working Experience
            $table->json('experience')->nullable();
            // Present Address
            $table->unsignedInteger('address_id')->nullable();
            // Bank Account Details
            $table->string('bank')->nullable();
            $table->string('beneficiary_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('income_tax_id')->nullable();
            // Medical Details
            $table->boolean('is_disabled')->default(false);
            $table->string('disability')->nullable();
            $table->string('disease')->nullable();
            $table->string('allergy')->nullable();
            $table->string('visible_marks')->nullable();
            $table->string('food_habit')->nullable();
            $table->text('medical_remarks')->nullable();
            // Maintenance Information
            $table->boolean('archived')->default(false)->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedInteger('school_id')->index();

            $table->json('additional')->default('[]');
            $table->softDeletes();
            $table->timestamps();

            // Constraints
            $table->foreign('photo_id')->references('id')->on('attachments');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('department_id')->references('id')->on('departments');
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
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['department_id']);
            $table->dropForeign(['address_id']);
            $table->dropForeign(['photo_id']);
            $table->drop();
        });
    }
}
