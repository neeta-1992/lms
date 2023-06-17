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
        if (!Schema::hasTable('state_program_setting_overrides')) {
            Schema::create('state_program_setting_overrides', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('state_program_id')->nullable()->default(null);
                $table->string('override_settings')->nullable()->default(null);
                $table->string('assigned_territory')->nullable()->default(null);
                $table->string('assigned_states')->nullable()->default(null);
                $table->string('value')->nullable()->default(null);
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
        Schema::dropIfExists('state_program_setting_overrides');
    }
};
