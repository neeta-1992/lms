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
    {/*
         if (!Schema::hasTable('insurance_notices') && config('database.default') !== "mysql") {
            Schema::create('insurance_notices', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users');
                $table->text('json')->nullable();
                $table->boolean('status')->nullable()->default(false);
                $table->timestamps();
            });
        } */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insurance_notices');
    }
};
