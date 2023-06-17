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

        if (!Schema::hasTable('quote_policies')) {
            Schema::create('quote_policies', function (Blueprint $table) {
                $table->uuid('id')->primary()->unique();
                $table->integer('user_id')->unsigned()->nullable()->default(null);
                $table->string('first_payment_due_date')->nullable()->default(null);
                $table->smallInteger('payment_due_days')->nullable()->default(0);
                $table->string('policy_number')->nullable()->default(null);
                $table->date('inception_date')->nullable()->default(null);
                $table->date('expiration_date')->nullable()->default(null);
                $table->date('first_installment_date')->nullable()->default(null);
                $table->smallInteger('insurance_company')->nullable()->default(0);
                $table->smallInteger('general_agent')->nullable()->default(0);
                $table->smallInteger('general_agent_branch')->nullable()->default(0);
                $table->smallInteger('broker')->nullable()->default(0);
                $table->smallInteger('coverage_type')->nullable()->default(0);
                $table->float('pure_premium')->nullable()->default(0);
                $table->float('minimum_earned')->nullable()->default(0);
                $table->smallInteger('cancel_terms')->nullable()->default(0);
                $table->string('term')->nullable()->default(null);
                $table->float('policy_fee')->nullable()->default(0);
                $table->float('taxes_and_stamp_fees')->nullable()->default(0);
                $table->float('broker_fee')->nullable()->default(0);
                $table->float('inspection_fee')->nullable()->default(0);
                $table->float('doc_stamp_fees')->nullable()->default(0);
                $table->string('short_rate')->nullable()->default(null);
                $table->string('auditable')->nullable()->default(null);
                $table->string('puc_filings')->nullable()->default(null);
                $table->text('notes')->nullable()->default(null);
                $table->float('total')->nullable()->default(0);
                $table->float('down_payment')->nullable()->default(0);
                $table->smallInteger('down_payment_increase')->nullable()->default(0);
                $table->uuid('quote')->nullable()->default(null);
                $table->uuid('version')->nullable()->default(null);
                $table->float('unearned_fees')->nullable()->default(0);
                $table->float('earned_fees')->nullable()->default(0);
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
        Schema::dropIfExists('quote_policies');
    }
};
