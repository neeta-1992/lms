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
        if(!Schema::hasTable('quote_signature_otps')){
            Schema::create('quote_signature_otps', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('user_id')->nullable()->default(0);
                $table->uuid('qid')->nullable()->default(null);
                $table->uuid('vid')->nullable()->default(null);
                $table->string('ip')->nullable()->default(null);
                $table->string('otp')->nullable()->default(null);
                $table->boolean('status')->nullable()->default(false);
                $table->datetime('start_time')->nullable()->default(null);
                $table->datetime('verify_time')->nullable()->default(null);
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
        Schema::dropIfExists('quote_signature_otps');
    }
};
