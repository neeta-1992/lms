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

        if (!Schema::hasTable('compensation_table_fees') && config('database.default') !== "mysql") {
            Schema::create('compensation_table_fees', function (Blueprint $table) {
                $table->id();
                $table->foreignId('compensation_id')->constrained('compensation_tables');
                $table->string('from')->nullable()->default(0);
                $table->string('to')->nullable()->default(0);
                $table->string('financed_rate')->nullable()->default(0);
                $table->string('markup')->nullable()->default(0);
                $table->string('add_on_points')->nullable()->default(0);
                $table->string('fee')->nullable()->default(0);
                $table->string('total_premium')->nullable()->default(0);
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
        Schema::dropIfExists('compensation_table_fees');
    }
};
