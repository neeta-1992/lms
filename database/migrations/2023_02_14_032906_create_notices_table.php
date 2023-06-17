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
        if (!Schema::hasTable('notices') && config('database.default') !== "mysql") {
            Schema::create('notices', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users');
                $table->integer('entity_id')->nullable()->default(0);
                $table->text('json')->nullable();
                $table->integer('default_email_notices')->nullable()->default(0);
                $table->integer('default_fax_notices')->nullable()->default(0);
                $table->string('default_mail_notices')->nullable()->default(0);
                $table->string('type')->nullable()->default(0);
                $table->boolean('status')->nullable()->default(false);
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
        Schema::dropIfExists('notices');
    }
};
