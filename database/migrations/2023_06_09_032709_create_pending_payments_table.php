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
       /*  Schema::table('entities', function (Blueprint $table) {
            $table->smallInteger('status')->nullable()->default(0)->after('entity_type');
        }); */
        if (!Schema::hasTable('pending_payments')) {
            Schema::create('pending_payments', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('user_id')->nullable()->default(null);
                $table->uuid('account_id')->nullable()->default(null);
                $table->smallInteger('payment_number')->nullable()->default(0);
                $table->decimal('due_late_fee', 10, 2)->nullable()->default(0);
                $table->decimal('due_cancel_fee', 10, 2)->nullable()->default(0);
                $table->decimal('due_nsf_fee', 10, 2)->nullable()->default(0);
                $table->decimal('due_convient_fee', 10, 2)->nullable()->default(0);
                $table->decimal('due_installment', 10, 2)->nullable()->default(0);
                $table->decimal('due_stop_payment', 10, 2)->nullable()->default(0);
                $table->string('payment_processing_order')->nullable()->default(null);
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
        Schema::dropIfExists('pending_payments');
    }
};
