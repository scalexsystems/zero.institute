<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Scalex\Zero\Models\Transaction;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');

            // Payment tracking.
            $table->bigInteger('amount'); // Always in paise.
            $table->boolean('refundable')->default(false);
            $table->enum('status', [
                Transaction::PENDING,
                Transaction::SUCCESSFUL,
                Transaction::FAILED,
            ])->default(Transaction::PENDING);

            // Gateway info.
            $table->string('gateway_reference_id')->nullable();
            $table->string('gateway')->nullable();
            $table->string('payment_method')->nullable();

            // Product info.
            $table->string('purpose');
            $table->text('description')->nullable();
            $table->morphs('payable');

            // Payer info.
            $table->ipAddress('ip')->nullable();
            $table->integer('user_id')->unsigned();

            // House keeping.
            $table->integer('school_id')->unsigned();
            $table->json('additional')->default('{}');
            $table->softDeletes();
            $table->timestamps();

            // Indices & Constraints.
            $table->index('school_id');
            $table->index(['gateway', 'transaction_id']);
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('SET NULL');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
