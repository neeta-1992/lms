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
        if (!Schema::hasTable('rate_table_fees')) {
            Schema::create('rate_table_fees', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users');
                $table->foreignId('rate_table_id')->constrained('rate_tables');
                $table->float('from')->nullable()->default(0);
                $table->float('to')->nullable()->default(0);
                $table->integer('rate')->nullable()->default(0);
                $table->float('setup_fee')->nullable()->default(0);
                $table->boolean('is_state_maximun')->nullable()->default(false);
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
        Schema::dropIfExists('rate_table_fees');
    }
};
