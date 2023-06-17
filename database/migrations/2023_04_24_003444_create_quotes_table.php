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
        Schema::create('quotes', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->integer('user_id')->unsigned()->nullable()->default(null);
            $table->integer('qid')->unsigned()->nullable()->default(null);
            $table->uuid('vid')->unsigned()->nullable()->default(null)->comment('version id for quote_version table');
            $table->uuid('insured_id')->unsigned()->nullable()->default(null)->comment('insured id for users table');
            $table->uuid('agent_id')->unsigned()->nullable()->default(null)->comment('agent id for users table');
            $table->uuid('agency_id')->unsigned()->nullable()->default(null)->comment('entities id for users table');
            $table->uuid('rate_table')->unsigned()->nullable()->default(null)->comment('entities id for users table');
            $table->integer('activation_insured')->unsigned()->nullable()->default(0);
            $table->integer('activation_agent')->unsigned()->nullable()->default(0);
            $table->integer('reverse_activation_agent')->unsigned()->nullable()->default(0);
            $table->integer('reverse_activation')->unsigned()->nullable()->default(0);
            $table->dateTime('activation_agent_date')->nullable()->default(null);
            $table->dateTime('underwriting_verification_date')->nullable()->default(null);
            $table->string('account_type',100)->unsigned()->nullable()->default(null);
            $table->string('quote_type',100)->unsigned()->nullable()->default(null);
            $table->string('origination_state',100)->unsigned()->nullable()->default(null);
            $table->string('payment_method',100)->unsigned()->nullable()->default(null);
            $table->string('payment_method_account_type',100)->unsigned()->nullable()->default(null);
            $table->float('insured_existing_balance')->nullable()->default(00.00);
            $table->string('bank_routing_number')->nullable()->default(null);
            $table->string('bank_account_number')->nullable()->default(null);
            $table->string('card_holder_name')->nullable()->default(null);
            $table->string('card_number')->nullable()->default(null);
            $table->string('end_date')->nullable()->default(null);
            $table->string('cvv')->nullable()->default(null);
            $table->string('cardholder_email')->nullable()->default(null);
            $table->string('account_name')->nullable()->default(null);
            $table->string('mailing_address')->nullable()->default(null);
            $table->string('mailing_city')->nullable()->default(null);
            $table->string('mailing_state')->nullable()->default(null);
            $table->string('mailing_zip')->nullable()->default(null);
            $table->string('email_notification')->nullable()->default(null);
            $table->text('quote_notes')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotes');
    }
};
