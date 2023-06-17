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
        if (!Schema::hasTable('account_alerts')) {
            Schema::create('account_alerts', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('user_id')->nullable()->default(null)->comment('user table');
                $table->uuid('account_id')->nullable()->default(null);
                $table->uuid('parent_id')->nullable()->default(null);
                $table->uuid('parent_id_append')->nullable()->default(null);
                $table->date('alert_date')->nullable()->default(null);
                $table->string('alert_subject')->nullable()->default(null);
                $table->string('category')->nullable()->default(null);
                $table->text('alert_text')->nullable()->default(null);
                $table->boolean('task')->nullable()->default(false);
                $table->boolean('append_status')->nullable()->default(false);
                $table->boolean('show_task')->nullable()->default(false);
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
        Schema::dropIfExists('account_alerts');
    }
};
