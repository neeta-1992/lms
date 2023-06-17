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
        if (!Schema::hasTable('account_status_settings')) {
                Schema::create('account_status_settings', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('user_id')->constrained('users');
                    $table->smallInteger('state_id')->nullable()->default(0);
                    $table->tinyInteger('account_days_overdue')->nullable()->default(0);
                    $table->tinyInteger('commercial_lines_days')->nullable()->default(0);
                    $table->tinyInteger('personal_lines_days')->nullable()->default(0);
                    $table->tinyInteger('fewer_days_remaining')->nullable()->default(0);
                    $table->tinyInteger('cancel_date_personal_lines')->nullable()->default(0);
                    $table->tinyInteger('cancel_date_commercial_lines')->nullable()->default(0);
                    $table->float('commercial_lines')->nullable()->default(0);
                    $table->float('personal_lines')->nullable()->default(0);
                    $table->tinyInteger('cancellation_notice_days')->nullable()->default(0);
                    $table->float('cancel_balance_due')->nullable()->default(0);
                    $table->tinyInteger('sending_cancel_days')->nullable()->default(0);
                    $table->tinyInteger('sending_cancel_days_collection')->nullable()->default(0);
                    $table->float('cancel_level_one')->nullable()->default(0);
                    $table->tinyInteger('most_recent_date_days')->nullable()->default(0);
                    $table->tinyInteger('maximum_automatic_amount')->nullable()->default(0);
                    $table->tinyInteger('unearned_interest')->nullable()->default(0);
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
        Schema::dropIfExists('account_status_settings');
    }
};
