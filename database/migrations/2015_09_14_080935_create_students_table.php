<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStudentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('students', function (Blueprint $table) {

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
            // Related to School
            $table->string('uid')->nullable();
            $table->date('date_of_admission')->nullable();
            $table->string('boarding_type')->nullable();
            $table->unsignedInteger('department_id')->nullable();
            $table->unsignedInteger('discipline_id')->nullable();
            $table->unsignedInteger('semester_id')->nullable();
            $table->string('biometric_id')->nullable();

            // Contact Information
            $table->unsignedInteger('address_id')->nullable();

            // Parent's Information
            $table->unsignedInteger('father_id')->nullable();
            $table->unsignedInteger('mother_id')->nullable();

            // Medical Information
            $table->boolean('is_disabled')->default(false)->nullable();
            $table->string('disability')->nullable();
            $table->string('disease')->nullable();
            $table->string('allergy')->nullable();
            $table->string('visible_marks')->nullable();
            $table->string('food_habit')->nullable();
            $table->text('medical_remarks')->nullable();

            // Additional Information

            // Maintenance Information
            $table->boolean('archived')->default(false)->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedInteger('school_id')->index();

            $table->json('additional')->default('[]');
            $table->softDeletes();
            $table->timestamps();

            // Constraints
            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('photo_id')->references('id')->on('attachments');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('discipline_id')->references('id')->on('disciplines');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreign('father_id')->references('id')->on('guardians');
            $table->foreign('mother_id')->references('id')->on('guardians');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['mother_id']);
            $table->dropForeign(['father_id']);
            $table->dropForeign(['semester_id']);
            $table->dropForeign(['discipline_id']);
            $table->dropForeign(['department_id']);
            $table->dropForeign(['address_id']);
            $table->dropForeign(['photo_id']);
            $table->dropForeign(['school_id']);
            $table->drop();
        });
    }
}
