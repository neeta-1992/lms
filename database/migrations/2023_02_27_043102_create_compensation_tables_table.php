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
      /*  if (!Schema::hasTable('compensation_tables') && config('database.default') !== "mysql") { */
           Schema::create('compensation_tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('name')->nullable()->default(null);
            $table->string('compensation')->nullable()->default(null);
            $table->boolean('status')->nullable()->default(false);
            $table->text('description')->nullable()->default(null);
            $table->timestamps();
        });
/*     } */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compensation_tables');
    }
};
