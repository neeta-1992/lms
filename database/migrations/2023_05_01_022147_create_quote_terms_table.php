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


        if (!Schema::hasTable('quote_terms')) {
            Schema::create('quote_terms', function (Blueprint $table) {
                $table->uuid('id')->primary()->unique();
                $table->uuid('quote')->nullable()->default(null);
                $table->uuid('version')->nullable()->default(null);
                $table->string('billing_schedule')->nullable()->default(null);
                $table->decimal('interest_rate',5, 2)->nullable()->default(0);
                $table->decimal('setup_fee',5, 2)->nullable()->default(0);
                $table->decimal('down_percent',5, 2)->nullable()->default(0);
                $table->decimal('number_of_payment',5,2)->nullable()->default(0);
                $table->decimal('pure_premium',10, 4)->nullable()->default(0);
                $table->decimal('broker_fee',10, 4)->nullable()->default(0);
                $table->decimal('policy_fee',10, 4)->nullable()->default(0);
                $table->decimal('taxes_and_stamp_fees',20, 4)->nullable()->default(0);
                $table->decimal('inspection_fee',10, 4)->nullable()->default(0);
                $table->decimal('doc_stamp_fees',10, 4)->nullable()->default(0);
                $table->decimal('total_fee',15, 4)->nullable()->default(0);
                $table->decimal('total_premium',10, 4)->nullable()->default(0);
                $table->decimal('down_payment',10, 4)->nullable()->default(0);
                $table->decimal('amount_financed',10, 4)->nullable()->default(0);
                $table->decimal('payment_amount_financed',10, 4)->nullable()->default(0);
                $table->decimal('total_interest',10, 4)->nullable()->default(0);
                $table->decimal('payment_amount',10, 4)->nullable()->default(0);
                $table->decimal('total_payment',10, 4)->nullable()->default(0);
                $table->decimal('total_interest_with_setup_fee',10, 4)->nullable()->default(0);
                $table->decimal('effective_apr',5, 2)->nullable()->default(0);
                $table->decimal('buy_rate',5, 2)->nullable()->default(0);
                $table->decimal('main_finance_charge',5, 2)->nullable()->default(0);
                $table->decimal('compensation',5, 2)->nullable()->default(0);
                $table->date('inception_date')->nullable()->default(null);
                $table->date('first_payment_due_date')->nullable()->default(null);
                $table->date('due_date')->nullable()->default(null);
              
               
                $table->timestamps();
            });

            
        }

       /*  Schema::table('quote_terms', function (Blueprint $table) {
           

             if (!Schema::hasColumn('messages', 'due_date')) {
                $table->date('due_date')->nullable()->default(null)->after('first_payment_due_date');
             }

             if (!Schema::hasColumn('quote_terms', 'compensation')) {
                $table->decimal('compensation',5, 2)->nullable()->default(0)->after('main_finance_charge');
             }

           
        });
 */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quote_terms');
    }
};
