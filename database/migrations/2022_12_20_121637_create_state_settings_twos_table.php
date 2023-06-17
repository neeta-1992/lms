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
        if(!Schema::hasTable('state_settings_twos')){
            Schema::create('state_settings_twos', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('state_settings_id')->nullable()->default(0);
                $table->string('max_setup_fee')->nullable()->default(null);
                $table->string('comm_max_setup_fee')->nullable()->default(null);
                $table->string('percentage_late_fee')->nullable()->default(null);
                $table->string('late_fee')->nullable()->default(null);
                $table->string('percentage_comm_late_fee')->nullable()->default(null);
                $table->string('late_fee_lesser_greater')->nullable()->default(null);
                $table->string('comm_late_fee')->nullable()->default(null);
                $table->string('late_fee_lesser_greater_comm')->nullable()->default(null);
                $table->string('percentage_minimum_late_fee')->nullable()->default(null);
                $table->string('minimum_late_fee')->nullable()->default(null);
                $table->string('percentage_comm_minimum_late_fee')->nullable()->default(null);
                $table->string('percentage_maximum_late_fee')->nullable()->default(null);
                $table->string('maximum_late_fee')->nullable()->default(null);
                $table->string('percentage_comm_maximum_late_fee')->nullable()->default(null);
                $table->string('comm_maximum_late_fee')->nullable()->default(null);
                $table->string('day_before_late_fee')->nullable()->default(null);
                $table->string('comm_day_before_late_fee')->nullable()->default(null);
                $table->string('cancellation_fee')->nullable()->default(null);
                $table->string('comm_cancellation_fee')->nullable()->default(null);
                $table->string('percentage_fee_credit_card')->nullable()->default(null);
                $table->string('fee_credit_card')->nullable()->default(null);
                $table->string('percentage_comm_fee_credit_card')->nullable()->default(null);
                $table->string('comm_fee_credit_card')->nullable()->default(null);
                $table->string('percentage_check_credit_card')->nullable()->default(null);
                $table->string('check_credit_card')->nullable()->default(null);
                $table->string('percentage_comm_check_credit_card')->nullable()->default(null);
                $table->string('comm_check_credit_card')->nullable()->default(null);
                $table->string('percentage_recurring_credit_card')->nullable()->default(null);
                $table->string('recurring_credit_card')->nullable()->default(null);
                $table->string('percentage_comm_recurring_credit_card')->nullable()->default(null);
                $table->string('comm_recurring_credit_card')->nullable()->default(null);
                $table->string('percentage_recurring_credit_card_check')->nullable()->default(null);
                $table->string('recurring_credit_card_check')->nullable()->default(null);
                $table->string('percentage_comm_recurring_credit_card_check')->nullable()->default(null);
                $table->string('comm_recurring_credit_card_check')->nullable()->default(null);
                $table->string('agent_rebates')->nullable()->default(null);
                $table->string('comm_agent_rebates')->nullable()->default(null);
                $table->string('policies_short_rate')->nullable()->default(null);
                $table->string('comm_minimum_late_fee')->nullable()->default(null);
                $table->string('comm_policies_short_rate')->nullable()->default(null);
                $table->softDeletes();
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
        Schema::dropIfExists('state_settings_twos');
    }
};
