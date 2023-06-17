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
       


        Schema::dropIfExists('daily_notices');
        if (!Schema::hasTable('daily_notices')) {
            Schema::create('daily_notices', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('account_id')->nullable()->default(null);
                $table->uuid('notice_id')->nullable()->default(null);
                $table->uuid('user_id')->nullable()->default(null);
                $table->uuid('send_id')->nullable()->default(null);
                $table->string('send_type')->nullable()->default(null);
                $table->uuid('quote_id')->nullable()->default(null);
                $table->uuid('version_id')->nullable()->default(null);
                $table->uuid('policy_id')->nullable()->default(null);
                $table->string('subject')->nullable()->default(null);
                $table->string('notice_name')->nullable()->default(null);
                $table->string('notice_action')->nullable()->default(null);
                $table->string('notice_type')->nullable()->default(null);
                $table->string('send_by')->nullable()->default(null);
                $table->string('account_number')->nullable()->default(null);
                $table->string('send_to')->nullable()->default(null);
                $table->longText('template')->nullable()->default(null);
                $table->mediumText('shortcodes')->nullable()->default(null);
                $table->smallInteger('status')->nullable()->default(1)->comment('1 = new 2 = process complete 3 = resend notice 4 = pending cancel notice 5 = cancel notice');
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
        Schema::dropIfExists('daily_notices');
    }
};
