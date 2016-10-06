<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create(
            'attachments',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('slug')->index();
                $table->string('title')->nullable();
                $table->string('disk')->nullable();
                $table->string('path');
                $table->string('mime');
                $table->string('filename');
                $table->string('extension');
                $table->unsignedInteger('size');
                $table->string('visibility');
                $table->json('variations')->default('[]');
                $table->json('additional')->nullable();
                $table->timestamps();

                $table->unsignedInteger('user_id')->nullable();
                $table->unsignedInteger('school_id')->nullable();
                $table->unsignedInteger('related_id')->nullable();
                $table->string('related_type')->nullable();

                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('school_id')->references('id')->on('schools');
                $table->index(['related_id', 'related_type']);
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
            'attachments',
            function (Blueprint $table) {
                $table->dropIndex(['related_id', 'related_type']);
                $table->dropForeign(['school_id']);
                $table->dropForeign(['user_id']);
                $table->drop();
            }
        );
    }
}
