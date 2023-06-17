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

        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('insured_name')->nullable()->default(null);
            $table->string('agent')->nullable()->default(null);
            $table->string('email_notification')->nullable()->default(null);
            $table->string('line_of_business')->nullable()->default(null);
            $table->string('quote_type')->nullable()->default(null);
            $table->string('rate_table')->nullable()->default(null);
            $table->string('origination_state')->nullable()->default(null);
            $table->string('payment_method')->nullable()->default(null);
            $table->string('insurance_company')->nullable()->default(null);
            $table->string('inception_date')->nullable()->default(null);
            $table->string('general_agent')->nullable()->default(null);
            $table->string('policy_term')->nullable()->default(null);
            $table->float('policy_number')->nullable()->default(0);
            $table->string('expiration_date')->nullable()->default(null);
            $table->string('coverage_type')->nullable()->default(null);
            $table->string('first_installment_date')->nullable()->default(null);
            $table->string('pure_premium')->nullable()->default(null);
            $table->float('policy_fee')->nullable()->default(0);
            $table->float('minimum_earned')->nullable()->default(0);
            $table->float('taxes_stamp_fees')->nullable()->default(0);
            $table->string('cancel_term_in_days')->nullable()->default(null);
            $table->float('broker_fee')->nullable()->default(0);
            $table->string('short_rate')->nullable()->default(null);
            $table->float('inspection_fee')->nullable()->default(0);
            $table->string('auditable')->nullable()->default(null);
            $table->string('puc_filings')->nullable()->default(null);
            $table->string('notes')->nullable()->default(null);
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
        Schema::dropIfExists('quotes');
    }
};
