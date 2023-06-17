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
        if (!Schema::hasTable('entity_contacts')) {
            Schema::create('entity_contacts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('entity_id')->constrained('entities');
                $table->string('first_name')->nullable()->default(null);
                $table->string('middle_name')->nullable()->default(null);
                $table->string('last_name')->nullable()->default(null);
                $table->string('title')->nullable()->default(null);
                $table->string('month')->nullable()->default(null);
                $table->string('day')->nullable()->default(null);
                $table->string('email')->nullable()->default(null);
                $table->string('telephone',50)->nullable()->default(null);
                $table->string('extension',50)->nullable()->default(null);
                $table->string('fax')->nullable()->default(null);
                $table->text('notes')->nullable()->default(null);
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
        Schema::dropIfExists('entity_contacts');
    }
};
