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
       /*  if (Schema::hasTable('fundings')) { */
            Schema::table('fundings', function (Blueprint $table) {
                $table->string('uneamed_compensation')->nullable()->default(null);
                $table->string('compensation_pay_using')->nullable()->default(null);
                $table->string('compensation_financial_institution_name')->nullable()->default(null);
                $table->string('compensation_routing_number')->nullable()->default(null);
                $table->string('compensation_account_number')->nullable()->default(null);
                $table->string('compensation_remittance_schedule')->nullable()->default(null);
                $table->string('compensation_days_after_policy_inception_text')->nullable()->default(null);
                $table->string('compensation_days_after_1st_payment_due_date_text')->nullable()->default(null);
                $table->string('products_paid_using')->nullable()->default(null);
                $table->string('products_financial_institution_name')->nullable()->default(null);
                $table->string('products_routing_number')->nullable()->default(null);
                $table->string('products_account_number')->nullable()->default(null);
                $table->string('refund_check_to')->nullable()->default(null);
                $table->string('refund_check_payable')->nullable()->default(null);
            });
      /*    } */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
