<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /* Schema::table('quote_account_exposures', function (Blueprint $table) {
            $table->json('json_payment_due_date')->nullable()->default(null)->after('payment_processing_order');
        }); */
        Schema::dropIfExists('transaction_histories');
        if (!Schema::hasTable('transaction_histories')) {
            Schema::create('transaction_histories', function (Blueprint $table) {
                $table->uuid('id')->unique();
                $table->bigIncrements('iid');
                $table->uuid('user_id')->nullable()->default(null);
                $table->uuid('payment_id')->nullable()->default(null);
                $table->uuid('account_id')->nullable()->default(null);
                $table->uuid('transaction_id')->nullable()->default(null);
                $table->integer('payment_number')->nullable()->default(0);
                $table->integer('new_payment_number')->nullable()->default(0);
                $table->string('transaction_type', 100)->nullable()->default(null);
                $table->string('reversal', 100)->nullable()->default(null);
                $table->string('type')->nullable()->default(null);
                $table->string('payment_method')->nullable()->default(null);
                $table->decimal('nsf_fee', 10, 2)->nullable()->default(0);
                $table->decimal('stop_payment_fee', 10, 2)->nullable()->default(0);
                $table->decimal('amount', 10, 2)->nullable()->default(0);
                $table->decimal('debit_fee', 10, 2)->nullable()->default(0);
                $table->decimal('debit', 10, 2)->nullable()->default(0);
                $table->decimal('credit', 10, 2)->nullable()->default(0);
                $table->decimal('balance', 10, 2)->nullable()->default(0);
                $table->decimal('last_balance', 10, 2)->nullable()->default(0);
                $table->decimal('interest', 10, 2)->nullable()->default(0);
                $table->text('resaon')->nullable()->default(null);
                $table->text('description')->nullable()->default(null);
                $table->boolean('system')->nullable()->default(false);
                $table->boolean('reverse_status')->nullable()->default(false);
                $table->integer('return_premium_commission')->unsigned()->nullable()->default(0);
                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_histories');
    }
};
