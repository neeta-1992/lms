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
        if (!Schema::hasTable('meta_tags') ) {
            Schema::create('meta_tags', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->foreignId('user_id')->constrained('users');
                $table->string('key',50)->nullable()->default(null);
                $table->string('type')->nullable()->default(null);
                $table->text('value')->nullable()->default(null);
                if(config('database.default') !== "mysql"){
                    $table->uuid('parent_id')->nullable()->default(null)->comment("Main Datatabase entities table id");
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
        Schema::dropIfExists('meta_tags');
    }
};
