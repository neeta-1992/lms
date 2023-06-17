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
        if (!Schema::hasTable('down_payments')) {
           Schema::create('down_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('name')->nullable()->default(null);
            $table->string('monthly_minimum_installment')->nullable()->default(null);
            $table->string('monthly_deafult_installment')->nullable()->default(null);
            $table->string('monthly_maximum_installment')->nullable()->default(null);
            $table->string('quarterly_minimum_installment')->nullable()->default(null);
            $table->string('quarterly_deafult_installment')->nullable()->default(null);
            $table->string('quarterly_maximum_installment')->nullable()->default(null);
            $table->string('annually_minimum_installment')->nullable()->default(null);
            $table->string('annually_deafult_installment')->nullable()->default(null);
            $table->string('annually_maximum_installment')->nullable()->default(null);
            $table->string('round_down_payment')->nullable()->default(null);
            $table->string('minimum_down_payment_policies')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->boolean('status')->nullable()->default(false);
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
        Schema::dropIfExists('down_payments');
    }
};
