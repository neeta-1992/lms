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
        if (!Schema::hasTable('attachments')) {
            Schema::create('attachments', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('user_id')->nullable()->default(0);
                $table->uuid('type_id')->nullable()->default(0);
                $table->string('subject')->nullable()->default(null);
                $table->string('original_filename')->nullable()->default(null);
                $table->string('filename')->nullable()->default(null);
            /*     $table->string('attachment_type')->nullable()->default(null); */
                $table->text('description')->nullable()->default(null);
                $table->string('type')->nullable()->default(null);
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
        Schema::dropIfExists('attachments');
    }
};
