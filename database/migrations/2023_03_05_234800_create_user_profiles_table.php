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
          if (!Schema::hasTable('user_profiles')) {
            Schema::create('user_profiles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users');
                $table->string('title')->nullable()->default(null);
                $table->integer('month')->nullable()->default(null);
                $table->integer('day')->nullable()->default(null);
                $table->integer('state_resident')->nullable()->default(null);
                $table->string('licence_no')->nullable()->default(null);
                $table->string('expiration_date')->nullable()->default(null);
                $table->string('convicted')->nullable()->default(null);
                $table->string('insurance_department')->nullable()->default(null);
                $table->string('notes')->nullable()->default(null);
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
        Schema::dropIfExists('user_profiles');
    }
};
