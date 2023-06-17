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
        if (!Schema::hasTable('finance_agreements')) {
            Schema::create('finance_agreements', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users');
                $table->string('name')->nullable()->default(null);
                $table->text('description')->nullable()->default(null);
                $table->longText('template')->nullable()->default(null);
                $table->boolean('status')->nullable()->default(false);
                if(config('database.default') !== "mysql"){
                    $table->integer('parent_id')->nullable()->default(null)->comment("Main Datatabase finance_agreements table id");
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
        Schema::dropIfExists('finance_agreements');
    }
};
