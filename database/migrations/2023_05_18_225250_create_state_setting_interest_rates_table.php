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
        Schema::dropIfExists('state_setting_interest_rates');
        if (!Schema::hasTable('state_setting_interest_rates')) {
            Schema::create('state_setting_interest_rates', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('state_setting_id');
                $table->float('from')->nullable()->default(0);
                $table->float('to')->nullable()->default(0);
                $table->integer('rate')->nullable()->default(0);
                $table->string('type')->nullable()->default(null);
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
        Schema::dropIfExists('state_setting_interest_rates');
    }
};
