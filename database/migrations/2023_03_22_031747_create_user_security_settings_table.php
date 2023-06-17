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
        if (!Schema::hasTable('user_security_settings')) {
            Schema::create('user_security_settings', function (Blueprint $table) {
                $table->id();
                $table->integer('user_type')->unsigned()->nullable()->default(0);
                $table->integer('minimum_length')->nullable()->default(0);
                $table->integer('minimum_digits')->nullable()->default(0);
                $table->integer('minimum_upper_case_letters')->nullable()->default(0);
                $table->integer('minimum_lower_case_letters')->nullable()->default(0);
                $table->integer('minimum_special_characters')->nullable()->default(0);
                $table->string('special_characters')->nullable()->default(null);
                $table->string('minimum_password_age')->nullable()->default(null);
                $table->integer('expires_every')->nullable()->default(0);
                $table->integer('number_unsuccessful_in')->nullable()->default(0);
                $table->integer('number_unsuccessful_minutes')->nullable()->default(0);
                $table->integer('number_inactivity_days')->nullable()->default(0);
                $table->string('prevent_reuse')->nullable()->default(null);
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
        Schema::dropIfExists('user_security_settings');
    }
};
