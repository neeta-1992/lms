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
       /*  if (!Schema::hasTable('quote_notes')) {
            Schema::create('quote_notes', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('qid')->nullable()->default(null);
                $table->uuid('vid')->nullable()->default(null);
                $table->uuid('user_id')->nullable()->default(0);
                $table->string('subject')->nullable()->default(null);
                $table->string('type')->nullable()->default(null);
                $table->text('description')->nullable()->default(null);
                $table->uuid('parent_id')->nullable()->default(null);
                $table->smallInteger('current_status')->nullable()->default(0);
                $table->boolean('show_status')->nullable()->default(false);
                $table->string('files',2010)->nullable()->default(null);
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
        Schema::dropIfExists('quote_notes');
    }
};
