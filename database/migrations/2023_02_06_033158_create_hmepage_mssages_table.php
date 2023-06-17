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
         if (!Schema::hasTable('hmepage_mssages') && config('database.default') !== "mysql") {
            Schema::create('hmepage_mssages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users');
                $table->integer('user_type')->nullable()->default(0);
                $table->dateTime('from_date')->nullable()->default(null);
                $table->dateTime('to_date')->nullable()->default(null);
                $table->text('body')->nullable();
                $table->boolean('status')->nullable()->default(false);
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
        Schema::dropIfExists('hmepage_mssages');
    }
};
