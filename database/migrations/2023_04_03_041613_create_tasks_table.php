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
        if (!Schema::hasTable('tasks')) {
            Schema::create('tasks', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->foreignId('user_id')->constrained('users');
                $table->uuid('parent_id')->nullable()->default(null);
                $table->string('subject')->nullable()->default(null);
                $table->text('notes')->nullable()->default(null);
                $table->text('remark')->nullable()->default(null);
                $table->text('description')->nullable()->default(null);
                $table->string('shedule')->nullable()->default(null);
                $table->string('priority')->nullable()->default(null);
                $table->string('status')->nullable()->default(null);
                $table->string('images')->nullable()->default(null);
                $table->string('assign_task')->nullable()->default(null);
                $table->smallInteger('view_status')->nullable()->default(0);
                $table->smallInteger('current_status')->nullable()->default(0);
                $table->smallInteger('show_task')->nullable()->default(0);
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
        Schema::dropIfExists('tasks');
    }
};
