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
        if (!Schema::hasTable('message_files')) {
            Schema::create('message_files', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('message')->nullable()->default(0);
                $table->string('original_name')->nullable()->default(null);
                $table->string('file_name')->nullable()->default(null);
                $table->string('file_type')->nullable()->default(null);
                $table->integer('message_type')->nullable()->default(0)->comment("1=>draft,2=>mail");
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
        Schema::dropIfExists('message_images');
    }
};
