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
        if (!Schema::hasTable('message_drafts')) {
            Schema::create('message_drafts', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->integer('user_id')->nullable()->default(null);
                $table->string('from_id')->nullable()->default(null);
                $table->string('to_id')->nullable()->default(null);
                $table->string('subject')->nullable()->default(null);
                $table->string('cc')->nullable()->default(null);
                $table->longText('message')->nullable()->default(null);
                $table->text('files')->nullable()->default(null);
                $table->softDeletes();
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
        Schema::dropIfExists('message_drafts');
    }
};
