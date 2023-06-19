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
      
        if (!Schema::hasTable('return_premium_commissions')) {
            Schema::create('return_premium_commissions', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('user_id')->nullable()->default(null);
                $table->uuid('account_id')->nullable()->default(null);
                $table->uuid('policy')->nullable()->default(null);
                $table->string('return_premium_from')->nullable()->default(null);
                $table->string('check_number')->nullable()->default(null);
                $table->string('bank_account')->nullable()->default(null);
                $table->string('apply_payment')->nullable()->default(null);
                $table->string('print_rp_notices')->nullable()->default(null);
                $table->string('reduce_remaining_interest')->nullable()->default(null);
                $table->string('first_payment_due_date')->nullable()->default(null);
                $table->string('agent_commission_due')->nullable()->default(null);
                $table->decimal('amount_paid', 20, 2)->nullable()->default(0.0);
                $table->smallInteger('status')->nullable()->default(0);
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
        Schema::dropIfExists('return_premium_commissions');
    }
};
