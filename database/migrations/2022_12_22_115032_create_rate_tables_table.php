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
        if (!Schema::hasTable('rate_tables')) {
            Schema::create('rate_tables', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users');
            
                $table->string('name')->nullable()->default(null);
                $table->string('type')->nullable()->default(null);
                $table->string('account_type')->nullable()->default(null);
                $table->string('state')->nullable()->default(null);
                $table->integer('coverage_type')->nullable()->default(null);
                $table->text('description')->nullable()->default(null);
                if(config('database.default') !== "mysql"){
                    $table->integer('parent_id')->nullable()->default(null)->comment("Main Datatabase rate_tables table id");
                }
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
        Schema::dropIfExists('rate_tables');
    }
};
