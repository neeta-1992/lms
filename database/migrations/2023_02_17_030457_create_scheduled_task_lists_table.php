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
         if (!Schema::hasTable('scheduled_task_lists') && config('database.default') == "mysql") {
                Schema::create('scheduled_task_lists', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('user_id')->constrained('users');
                    $table->string('task_name')->nullable()->default(null);
                    $table->string('how_often')->nullable()->default(null);
                    $table->string('start_time')->nullable()->default(null);
                    $table->string('us_time_zone')->nullable()->default(null);
                    $table->string('start_date')->nullable()->default(null);
                    $table->string('description')->nullable()->default(null);
                    $table->string('end_date')->nullable()->default(null);
                    $table->boolean('status')->nullable()->default(false);
                    $table->string('type')->nullable()->default(false);
                    $table->integer('parent_id')->nullable()->default(null)->comment("scheduled task table id");
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
        Schema::dropIfExists('scheduled_task_lists');
    }
};
