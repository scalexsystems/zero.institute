<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create(
            'users',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->unsignedInteger('photo_id')->nullable();

                // Person - User link.
                $table->unsignedInteger('person_id')->nullable();
                $table->string('person_type')->nullable();

                // Bind to school.
                $table->unsignedInteger('school_id')->nullable();

                // JSON extensible.
                $table->json('additional')->default('[]');

                // Email verification token.
                $table->string('verification_token')->nullable();

                $table->rememberToken();
                $table->softDeletes();
                $table->timestamps();

                // Indices.
                $table->index(['person_id', 'person_type']);
                $table->foreign('school_id')->references('id')->on('schools');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table(
            'users',
            function (Blueprint $table) {
                $table->dropForeign(['school_id']);
                $table->dropIndex(['person_id', 'person_type']);
                $table->drop();
            }
        );
    }
}
