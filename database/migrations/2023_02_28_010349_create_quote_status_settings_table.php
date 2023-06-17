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
        /*  if (!Schema::hasTable('quote_status_settings') && config('database.default') !== "mysql") { */
            Schema::create('quote_status_settings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users');
                $table->string('name')->nullable()->default(0);
                $table->text('description')->nullable()->default(null);
                $table->boolean('status')->nullable()->default(false);
                $table->timestamps();
            });
        /* } */

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quote_status_settings');
    }
};
