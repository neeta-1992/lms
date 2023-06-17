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
        if (!Schema::hasTable('agent_other_settings')) {
            Schema::create('agent_other_settings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('agency_id')->constrained('entities');
                $table->string('down_payment_increase')->nullable()->default(null);
                $table->string('program')->nullable()->default(null);
                $table->string('loan_origination_state')->nullable()->default(null);
                $table->string('origination_state_override')->nullable()->default(null);
                $table->string('down_payment_rule_original_quoting')->nullable()->default(null);
                $table->string('down_payment_rule_ap_quoting')->nullable()->default(null);
                $table->string('printing_below_amount_financed')->nullable()->default(null);
                $table->string('printing_above_amount_financed')->nullable()->default(null);
                $table->string('modify_quote_interest_rate')->nullable()->default(null);
                $table->string('quote_point')->nullable()->default(null);
                $table->string('quotes_point_user_group')->nullable()->default(null);
                $table->string('account_point')->nullable()->default(null);
                $table->string('accounts_point_user_group')->nullable()->default(null);
                $table->string('marketing_point')->nullable()->default(null);
                $table->string('marketing_point_user_group')->nullable()->default(null);
                $table->string('processing_fee_table')->nullable()->default(null);
                $table->string('email_message_read_only')->nullable()->default(null);
                $table->string('default_email_subject')->nullable()->default(null);
                $table->string('email_subject_read_only')->nullable()->default(null);
                $table->string('agent_signs')->nullable()->default(null);
                $table->string('insured_signs')->nullable()->default(null);
                $table->string('require_approval_step')->nullable()->default(null);
                $table->string('approver_label')->nullable()->default(null);
                $table->text('default_email_message')->nullable()->default(null);
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
        Schema::dropIfExists('agent_other_settings');
    }
};
