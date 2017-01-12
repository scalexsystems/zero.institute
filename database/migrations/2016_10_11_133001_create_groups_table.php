<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type')->nullable();
            $table->boolean('private')->default(false);

            $table->unsignedInteger('owner_id');
            $table->unsignedBigInteger('photo_id')->nullable();
            $table->unsignedInteger('school_id')->nullable()->index();

            $table->json('additional')->default('[]');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('photo_id')->references('id')->on('attachments');
            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('school_id')->references('id')->on('schools');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['owner_id']);
            $table->dropForeign(['photo_id']);
            $table->drop();
        });
    }
}
