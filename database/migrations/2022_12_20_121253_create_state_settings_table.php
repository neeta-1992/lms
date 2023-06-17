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
       if(!Schema::hasTable('state_settings')){
            Schema::create('state_settings', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->integer('state')->nullable()->default(0);
                $table->string('refund_send_check')->nullable()->default(null);
                $table->string('spread_method')->nullable()->default(null);
                $table->string('refund_required')->nullable()->default(null);
                $table->string('interest_earned_start_date')->nullable()->default(null);
                $table->string('interest_earned_stop_date')->nullable()->default(null);
                $table->string('licensed_personal')->nullable()->default(null);
                $table->string('nsf_fees')->nullable()->default(null);
                $table->string('percentage_nsf_fee')->nullable()->default(null);
                $table->string('nsf_fee_lesser_greater')->nullable()->default(null);
                $table->string('licensed_commercial')->nullable()->default(null);
                $table->string('maximum_charge')->nullable()->default(null);
                $table->string('agent_authority')->nullable()->default(null);
                $table->string('late_fees')->nullable()->default(null);
                $table->string('refund_payable')->nullable()->default(null);
                $table->string('personal_maximum_finance_amount')->nullable()->default(null);
                $table->string('commercial_maximum_finance_amount')->nullable()->default(null);
                $table->string('minimum_interest')->nullable()->default(null);
                $table->string('comm_minimum_interest')->nullable()->default(null);
                $table->string('maximum_rate')->nullable()->default(null);
                $table->string('comm_maximum_rate')->nullable()->default(null);
                $table->string('maximum_setup_fee')->nullable()->default(null);
                $table->string('percentage_maximum_setup_fee')->nullable()->default(null);
                $table->string('maximum_setup_fee_lesser_greater')->nullable()->default(null);
                $table->string('comm_maximum_setup_fee')->nullable()->default(null);
                $table->string('percentage_comm_maximum_setup_fee')->nullable()->default(null);
                $table->string('maximum_comm_setup_fee_lesser_greater')->nullable()->default(null);
                $table->string('setup_percent')->nullable()->default(null);
                $table->string('comm_setup_percent')->nullable()->default(null);
                $table->string('due_date_intent_cancel')->nullable()->default(null);
                $table->string('comm_due_date_intent_cancel')->nullable()->default(null);
                $table->string('intent_cancel')->nullable()->default(null);
                $table->string('comm_intent_cancel')->nullable()->default(null);
                $table->string('effective_cancel')->nullable()->default(null);
                $table->string('comm_effective_cancel')->nullable()->default(null);
                $table->foreignId('user_id')->constrained('users');
                $table->integer('status')->unsigned()->nullable()->default(0);
                if(config('database.default') !== "mysql"){
                    $table->integer('parent_id')->nullable()->default(null)->comment("Main Datatabase state_settings table id");
                }
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
        Schema::dropIfExists('state_settings');
    }
};
