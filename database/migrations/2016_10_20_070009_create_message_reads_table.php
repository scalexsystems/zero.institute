<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageReadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('message_reads', function (Blueprint $table) {
            if (config('database.default') === 'memory') {
                $table->bigIncrements('id');
            }

            $table->unsignedInteger('message_id');
            $table->unsignedInteger('user_id');
            $table->timestamp('read_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('message_reads');
    }
}
