<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSchoolsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');

            // School Information
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->unsignedInteger('address_id')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();

            // Institute Info
            $table->string('medium')->nullable();
            $table->string('university')->nullable();
            $table->string('institute_type')->nullable();
            $table->string('timezone')->nullable();
            $table->unsignedInteger('logo_id')->nullable();

            $table->boolean('verified')->default(false);

            $table->json('additional')->default('[]');
            $table->softDeletes();
            $table->timestamps();

            // Constraints
            $table->foreign('address_id')->references('id')->on('addresses');
        });

        Schema::table('attachments', function (Blueprint $table) {
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
        Schema::table('attachments', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
        });
        Schema::table('schools', function (Blueprint $table) {
            $table->dropForeign(['address_id']);
            $table->drop();
        });
    }
}
