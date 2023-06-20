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

        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('user_id')->nullable()->default(null);
                $table->uuid('account_id')->nullable()->default(null);
                $table->uuid('bank_account')->nullable()->default(null);
                $table->smallInteger('payment_number')->nullable()->default(0);
                $table->smallInteger('status')->nullable()->default(0)->comment('0=open 1=complete 2=reverse 3=Return Premium');
                $table->string('payment_method')->nullable()->default(null);
                $table->string('notes')->nullable()->default(null);
                $table->string('card_number')->nullable()->default(null);
                $table->string('expiration_date')->nullable()->default(null);
                $table->string('cvv')->nullable()->default(null);
                $table->string('zip')->nullable()->default(null);
                $table->string('account_holder_name')->nullable()->default(null);
                $table->string('bank_name')->nullable()->default(null);
                $table->string('routing_number')->nullable()->default(null);
                $table->string('account_number')->nullable()->default(null);
                $table->string('reference')->nullable()->default(null);
                $table->decimal('installment_pay', 10,4)->nullable()->default(0);
                $table->decimal('late_fee', 10, 4)->nullable()->default(0);
                $table->decimal('cancel_fee', 10, 4)->nullable()->default(0);
                $table->decimal('nsf_fee', 10, 4)->nullable()->default(0);
                $table->decimal('convient_fee', 10, 4)->nullable()->default(0);
                $table->decimal('stop_payment', 10, 4)->nullable()->default(0);
                $table->decimal('amount', 10, 4)->nullable()->default(0);
                $table->decimal('total_due', 10, 4)->nullable()->default(0);
                $table->string('received_from')->nullable()->default(0);
                $table->string('sqtoken')->nullable()->default(null);
                $table->string('square_payment_id')->nullable()->default(null);
                $table->boolean('payoff_status')->nullable()->default(false);
                $table->smallInteger('payment_type')->nullable()->default(0)->comment('0=>regular,1=>recurring');
                $table->text('installment_json')->nullable()->default(null);
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
        Schema::dropIfExists('payments');
    }
};
