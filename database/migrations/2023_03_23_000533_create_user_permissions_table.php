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
        if (!Schema::hasTable('user_permissions')) {
            Schema::create('user_permissions', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id')->nullable()->default(0);
                $table->integer('user_type')->nullable()->default(0);
                $table->string('days_allowed_to_modify_due_date')->nullable()->default(null);
                $table->string('days_allowed_to_suspend_accounts')->nullable()->default(null);
                $table->string('days_to_suspend_account_after_payment')->nullable()->default(null);
                $table->string('quote_activation_review_limit')->nullable()->default(null);
                $table->string('quote_activation_limit')->nullable()->default(null);
                $table->string('ap_quote_start_installment_threshold_days')->nullable()->default(null);
                $table->string('convenience_fee_override')->nullable()->default(null);
                $table->longText('permissions')->nullable()->default(null);
                $table->longText('reports')->nullable()->default(null);
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
        Schema::dropIfExists('user_permissions');
    }
};
