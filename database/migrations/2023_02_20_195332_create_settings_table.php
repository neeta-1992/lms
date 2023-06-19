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
      /*   if (!Schema::hasTable('settings') && config('database.default') !== "mysql") { */
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users');
                $table->longText('json')->nullable()->default(null);
                $table->string('type')->nullable()->default(null);
                $table->integer('user_type')->nullable()->default(0);
                $table->timestamps();
            });
      /*   } */

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};