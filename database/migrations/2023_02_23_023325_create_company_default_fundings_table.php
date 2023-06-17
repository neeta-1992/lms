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
       // if (!Schema::hasTable('company_default_fundings') && config('database.default') !== "mysql" ) {
        /*     Schema::create('company_default_fundings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users');
                $table->integer('type')->nullable()->default(0);
                $table->string('remittance_paid')->nullable()->default(null);
                $table->string('compensation_pay_using')->nullable()->default(null);
                $table->string('products_paid_using')->nullable()->default(null);
                $table->string('financial_institution_name')->nullable()->default(null);
                $table->string('routing_number')->nullable()->default(null);
                $table->string('account_number')->nullable()->default(null);
                $table->string('remittance_schedule')->nullable()->default(null);
                $table->string('compensation_financial_institution_name')->nullable()->default(null);
                $table->string('compensation_routing_number')->nullable()->default(null);
                $table->string('compensation_account_number')->nullable()->default(null);
                $table->string('products_financial_institution_name')->nullable()->default(null);
                $table->string('products_routing_number')->nullable()->default(null);
                $table->string('products_account_number')->nullable()->default(null);
                $table->string('compensation_remittance_schedule')->nullable()->default(null);
                $table->string('days_after_policy_inception_text')->nullable()->default(null);
                $table->string('days_after_1st_payment_due_date_text')->nullable()->default(null);
                $table->string('compensation_days_after_policy_inception_text')->nullable()->default(null);
                $table->string('compensation_days_after_1st_payment_due_date_text')->nullable()->default(null);
                $table->string('funding_address')->nullable()->default(null);
                $table->string('funding_address_second')->nullable()->default(null);
                $table->string('funding_city')->nullable()->default(null);
                $table->string('funding_state')->nullable()->default(null);
                $table->boolean('funding_address_checkbox')->nullable()->default(false);
                $table->boolean('hold_all_payables')->nullable()->default(false);
                $table->smallInteger('general_default')->nullable()->default(0);
                $table->smallInteger('deposit_default')->nullable()->default(0);
                $table->smallInteger('deposit_credit_card')->nullable()->default(0);
                $table->smallInteger('deposit_eCheck')->nullable()->default(0);
                $table->smallInteger('remittance_default')->nullable()->default(0);
                $table->smallInteger('remittance_check')->nullable()->default(0);
                $table->smallInteger('remittance_draft')->nullable()->default(0);
                $table->timestamps();
            }); */
      //  }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_default_fundings');
    }
};
