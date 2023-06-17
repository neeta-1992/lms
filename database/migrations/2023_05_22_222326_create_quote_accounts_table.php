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
        Schema::dropIfExists('quote_accounts');
        if (!Schema::hasTable('quote_accounts')) {
            Schema::create('quote_accounts', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('user_id')->nullable()->default(null);
                $table->string('account_number');
                $table->uuid('quote')->nullable()->default(null);
                $table->uuid('version')->nullable()->default(null);
                $table->uuid('insured')->nullable()->default(null)->comment('insured id for  table');
                $table->uuid('insured_uid')->nullable()->default(null)->comment('insured id for users table');
                $table->uuid('agent')->nullable()->default(null)->comment('agent id for users table');
                $table->uuid('agency')->nullable()->default(null)->comment('entities id for users table');
                $table->float('insured_existing_balance')->nullable()->default(00.00);
                $table->integer('reverse_activation')->unsigned()->nullable()->default(0);
                $table->dateTime('activation_agent_date')->nullable()->default(null);
                $table->dateTime('underwriting_verification_date')->nullable()->default(null);
                $table->string('account_type',100)->nullable()->default(null);
                $table->string('quote_type',100)->nullable()->default(null);
                $table->string('origination_state',100)->nullable()->default(null);
                $table->string('payment_method',100)->nullable()->default(null);
                $table->string('payment_method_account_type',100)->nullable()->default(null);
                $table->string('bank_name')->nullable()->default(null);
                $table->string('bank_routing_number')->nullable()->default(null);
                $table->string('bank_account_number')->nullable()->default(null);
                $table->string('card_holder_name')->nullable()->default(null);
                $table->string('card_number')->nullable()->default(null);
                $table->string('end_date')->nullable()->default(null);
                $table->string('cvv')->nullable()->default(null);
                $table->string('cardholder_email')->nullable()->default(null);
                $table->string('card_token')->nullable()->default(null);
                $table->string('square_card_id')->nullable()->default(null);
                $table->string('square_customer_id')->nullable()->default(null);
                $table->string('account_name')->nullable()->default(null);
                $table->string('mailing_address')->nullable()->default(null);
                $table->string('mailing_city')->nullable()->default(null);
                $table->string('mailing_state')->nullable()->default(null);
                $table->string('mailing_zip')->nullable()->default(null);
                $table->string('mailing_firstname')->nullable()->default(null);
                $table->string('mailing_lastname')->nullable()->default(null);
                $table->string('mailing_telephone')->nullable()->default(null);
                $table->string('mailing_email')->nullable()->default(null);
                $table->string('mailing_company')->nullable()->default(null);
                $table->string('coupon_name')->nullable()->default(null);
                $table->json('state_settings')->nullable()->default(null);
                $table->decimal('latecharge', 5, 2)->nullable()->default(0);
                $table->smallInteger('overdate_per_account')->nullable()->default(0);
                $table->smallInteger('cancel_days')->nullable()->default(0);
              
                $table->dateTime('cancel_date')->nullable()->default(null);
               
                $table->date('effective_date')->nullable()->default(null);
                
                $table->integer('overdue_account')->unsigned()->nullable()->default(0);
                $table->string('email_notification')->nullable()->default(null);
              
                $table->string('originationstate')->nullable()->default(null);
                $table->string('quoteoriginationstate')->nullable()->default(null);
                
                $table->boolean('suspend_status')->nullable()->default(false);
                $table->dateTime('suspend_date')->nullable()->default(null);
                $table->dateTime('unsuspend_date')->nullable()->default(null);
                $table->text('suspend_reason')->nullable()->default(null);
                $table->uuid('suspend_user')->unsigned()->nullable()->default(null);
                $table->smallInteger('status')->nullable()->default(0);
                $table->smallInteger('payment_status')->nullable()->default(0)->comment('0=>not start,-1= pading,1=>success payment,2=> completed Payment');
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
        Schema::dropIfExists('quote_accounts');
    }
};
