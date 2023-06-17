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
        Schema::create('quote_policy_account_exposures', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('account_id')->nullable()->default(null);
            $table->uuid('policy_id')->nullable()->default(null);
            $table->integer('payment_number')->unsigned()->nullable()->default(0);
            $table->dateTime('payment_due_date')->nullable()->default(null);
            $table->decimal('amount_financed', 20, 4)->nullable()->default(0);
            $table->decimal('monthly_payment', 20, 4)->nullable()->default(0);
            $table->decimal('interest', 5, 4)->nullable()->default(0);
            $table->decimal('principal', 20, 4)->nullable()->default(0);
            $table->decimal('principal_balance', 20, 4)->nullable()->default(0);
            $table->decimal('payoff_balance', 20, 4)->nullable()->default(0);
            $table->decimal('interest_refund', 20, 4)->nullable()->default(0);
            $table->integer('status')->unsigned()->nullable()->default(0);
            $table->decimal('pay_interest', 20, 4)->nullable()->default(0);
            $table->decimal('pay_amount', 20, 4)->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quote_policy_account_exposures');
    }
};
