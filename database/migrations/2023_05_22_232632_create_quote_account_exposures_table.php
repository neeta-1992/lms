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
        
        if (!Schema::hasTable('quote_account_exposures')) {
            Schema::create('quote_account_exposures', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('account_id')->nullable()->default(null);
                $table->integer('payment_number')->unsigned()->nullable()->default(0);
                $table->dateTime('payment_due_date')->nullable()->default(null);
                $table->decimal('amount_financed', 20, 4)->nullable()->default(0);
                $table->decimal('monthly_payment', 20, 4)->nullable()->default(0);
                $table->decimal('interest', 5, 4)->nullable()->default(0);
                $table->decimal('principal', 20, 4)->nullable()->default(0);
                $table->decimal('principal_balance', 20, 4)->nullable()->default(0);
                $table->decimal('payoff_balance', 20, 4)->nullable()->default(0);
                $table->decimal('interest_refund', 20, 4)->nullable()->default(0);
                $table->dateTime('current_payment_date')->nullable()->default(null);
                $table->dateTime('prev_payment_date')->nullable()->default(null);
                $table->text('payment_notes')->nullable()->default(null);
                $table->integer('status')->unsigned()->nullable()->default(0);
                $table->decimal('late_fee', 20, 4)->nullable()->default(0);
                $table->decimal('cancel_fee', 20, 4)->nullable()->default(0);
                $table->decimal('nsf_fee', 20, 4)->nullable()->default(0);
                $table->decimal('convient_fee', 20, 4)->nullable()->default(0);
                $table->decimal('stop_payment_fee', 20, 4)->nullable()->default(0);
                $table->decimal('pay_interest', 20, 4)->nullable()->default(0);
                $table->decimal('advance_payamount', 20, 4)->nullable()->default(0);
                $table->decimal('advance_installment', 20, 4)->nullable()->default(0);
                $table->string('payment_processing_order', 100)->nullable()->default(null);
                $table->json('json_payment_due_date')->nullable()->default(null);
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
        Schema::dropIfExists('quote_account_exposures');
    }
};
