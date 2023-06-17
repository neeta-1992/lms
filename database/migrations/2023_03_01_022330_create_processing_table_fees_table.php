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
         if (!Schema::hasTable('processing_table_fees')) {
            Schema::create('processing_table_fees', function (Blueprint $table) {
                $table->id();
                $table->foreignId('processing_table_id')->constrained('processing_tables');
                $table->string('from')->nullable()->default(0);
                $table->string('to')->nullable()->default(0);
                $table->string('fee')->nullable()->default(0);
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
        Schema::dropIfExists('processing_table_fees');
    }
};
