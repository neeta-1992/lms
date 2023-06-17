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
        if (!Schema::hasTable('quote_signatures')) {
            Schema::create('quote_signatures', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('user_id')->nullable()->default(0);
                $table->uuid('qid')->nullable()->default(null);
                $table->uuid('vid')->nullable()->default(null);
                $table->string('ip', 20)->default(null);
                $table->smallInteger('index')->nullable()->default(0);
                $table->string('current_datetime',50)->nullable()->default(null);
                $table->string('type',50)->nullable()->default(null);
                $table->string('title')->nullable()->default(null);
                $table->string('email')->nullable()->default(null);
                $table->string('name')->nullable()->default(null);
                $table->string('timezone',50)->nullable()->default(null);
                $table->string('region')->nullable()->default(null);
                $table->string('city',50)->nullable()->default(null);
                $table->string('lat',20)->nullable()->default(null);
                $table->string('longs',20)->nullable()->default(null);
                $table->string('country',50)->nullable()->default(null);
                $table->string('signature_text')->nullable()->default(null);
                $table->string('signature_font',50)->nullable()->default(null);
                $table->string('agree')->nullable()->default(null);
                $table->string('action',50)->nullable()->default(null);
                $table->boolean('status')->nullable()->default(false);
                $table->longText('signature')->nullable()->default('text');
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
        Schema::dropIfExists('quote_signatures');
    }
};
