<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('landmark')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Can be used with many types of users.
            $table->string('addressee_type')->nullable();
            $table->uuid('addressee_id')->nullable();

            // JSON expendable schema.
            $table->json('additional')->default('[]')->nullable();

            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->drop();
        });
    }
}
