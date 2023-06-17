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
       /*   if (!Schema::hasTable('quote_settings') && config('database.default') !== "mysql") {  */
            Schema::create('quote_settings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users');
                $table->string('loan_origination_state',50)->nullable()->default(null);
                $table->string('line_business',50)->nullable()->default(null);
                $table->float('policy_minium_earned_percent')->nullable()->default(0);
                $table->float('until_first_payment')->nullable()->default(0);
                $table->float('first_due_date')->nullable()->default(0);
                $table->float('new_quote_expiration')->nullable()->default(0);
                $table->float('renewal_quote_expiration')->nullable()->default(0);
                $table->string('payment_type_commercial')->nullable()->default(null);
                $table->string('payment_type_personal')->nullable()->default(null);
                $table->string('stamp_fees')->nullable()->default(null);
                $table->float('doc_stamp_fees')->nullable()->default(0);
                $table->float('down_percent')->nullable()->default(0);
                $table->integer('quick_quote')->nullable()->default(0);
                $table->string('ofac_compliance')->nullable()->default(null);
                $table->string('billing_schedule')->nullable()->default(null);
                $table->string('quote_type')->nullable()->default(null);
                $table->string('email_notification')->nullable()->default(null);
                $table->float('personal_maximum_finance_amount')->nullable()->default(0);
                $table->float('commercial_maximum_finance_amount')->nullable()->default(0);
                $table->string('short_rate')->nullable()->default(null);
                $table->string('require_insured_phone')->nullable()->default(null);
                $table->string('proprietor_require')->nullable()->default(null);
                $table->string('puc_filings')->nullable()->default(null);
                $table->string('auditable')->nullable()->default(null);
                $table->string('personal_lines')->nullable()->default(null);
                $table->string('coupon_payment')->nullable()->default(null);
                $table->string('credit_card_payment')->nullable()->default(null);
                $table->string('ach_payment')->nullable()->default(null);
                $table->string('request_activation')->nullable()->default(null);
                $table->string('quote_activation')->nullable()->default(null);
                $table->string('broker_field')->nullable()->default(null);
                $table->string('policy_fee_commercial')->nullable()->default(null);
                $table->string('policy_fee_personal')->nullable()->default(null);
                $table->string('unearned_fees')->nullable()->default(null);
                $table->string('tax_stamp_commercial')->nullable()->default(null);
                $table->string('tax_stamp_personal')->nullable()->default(null);
                $table->string('broker_fee_commercial')->nullable()->default(null);
                $table->string('broker_fee_personal')->nullable()->default(null);
                $table->string('inspection_fee_commercial')->nullable()->default(null);
                $table->string('inspection_fee_personal')->nullable()->default(null);
                $table->integer('calculating_agency')->nullable()->default(null);
                $table->integer('insured_existing_balance')->nullable()->default(null);
                $table->integer('first_due_dates')->nullable()->default(null);
                $table->integer('bank_risk_rating')->nullable()->default(null);
                $table->integer('limit_company')->nullable()->default(null);
                $table->integer('recourse_amount')->nullable()->default(null);
                $table->integer('ap_interest')->nullable()->default(null);
                $table->integer('ap_endorsement')->nullable()->default(null);
                $table->integer('endorsement_setup_fee')->nullable()->default(null);
                $table->integer('agency_name_sig')->nullable()->default(null);
                $table->integer('salesexecs')->nullable()->default(null);
                $table->integer('ach_receipt')->nullable()->default(null);
                $table->integer('payment_schedule')->nullable()->default(null);
                $table->integer('add_products')->nullable()->default(null);
                $table->integer('company_tax_validation')->nullable()->default(null);
                $table->integer('agent_rate_table')->nullable()->default(null);
                $table->integer('view_quote_exposure')->nullable()->default(null);
                $table->integer('view_agent_compensation')->nullable()->default(null);
                $table->text('patriot_message')->nullable()->default(null);
                $table->text('e_signature')->nullable()->default(null);
                $table->string('ofac_url')->nullable()->default(null);
                $table->string('accuity_client')->nullable()->default(null);
                $table->string('allow_inception_date')->nullable()->default(null);
                $table->string('accuity_service_url')->nullable()->default(null);
                $table->integer('warning_inception_date')->nullable()->default(null);
                $table->integer('warning_first_due_date')->nullable()->default(null);
                $table->integer('warning_first_due_date_number')->nullable()->default(null);
                $table->text('text_signature')->nullable()->default(null);
                $table->timestamps();
            });
        /*  } */

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quote_settings');
    }
};
