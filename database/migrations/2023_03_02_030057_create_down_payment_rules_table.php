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
          if (!Schema::hasTable('down_payment_rules')) {
           Schema::create('down_payment_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('down_payment_id')->constrained('down_payments');
            $table->string('rule_name')->nullable()->default(null);
            $table->string('minimum_down_payment')->nullable()->default(null);
            $table->string('down_payment_increase')->nullable()->default(null);
            $table->string('deafult_down_payment')->nullable()->default(null);
            $table->string('dollar_down_payment')->nullable()->default(null);
            $table->string('minimum_installment')->nullable()->default(null);
            $table->string('maximumm_installment')->nullable()->default(null);
            $table->string('deafult_installment')->nullable()->default(null);
            $table->string('first_due_date')->nullable()->default(null);
            $table->string('override_minimum_earned')->nullable()->default(null);
            $table->string('agency')->nullable()->default(null);
            $table->text('rule_description')->nullable()->default(null);
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
        Schema::dropIfExists('down_payment_rules');
    }
};
