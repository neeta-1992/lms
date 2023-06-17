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
        if (!Schema::hasTable('prospects')) {
            Schema::create('prospects', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users');
                $table->string('agency')->nullable()->default(null);
                $table->string('name')->nullable()->default(null);
                $table->string('legal_name')->nullable()->default(null);
                $table->string('email')->nullable()->default(null);
                $table->string('website')->nullable()->default(null);
                $table->string('address')->nullable()->default(null);
                $table->string('city')->nullable()->default(null);
                $table->string('state')->nullable()->default(null);
                $table->string('zip')->nullable()->default(null);
                $table->string('sales_organization')->nullable()->default(null);
                $table->json('other_fields')->nullable()->default(null);
                $table->text('notes')->nullable()->default(null);
                $table->integer('status')->nullable()->default(0);
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
        Schema::dropIfExists('prospects');
    }
};
