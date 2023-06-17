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
        Schema::dropIfExists('cancellation_reasons');
        Schema::create('cancellation_reasons', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained('users');
            $table->text('description')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->boolean('status')->nullable()->default(false);
             if(config('database.default') !== "mysql"){ 
                $table->uuid('parent_id')->nullable()->default(null)->comment("Main Datatabase rate_tables table id");
           } 
            $table->timestamps();
        });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cancellation_reasons');
    }
};
