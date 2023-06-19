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

     
        if (!Schema::hasTable('payments_histories')) {
            Schema::create('payments_histories', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('user_id')->nullable()->default(null);
                $table->string('payment_ids',2005)->nullable()->default(null);
                $table->smallInteger('total_deposits')->nullable()->default(0);
                $table->decimal('deposit_amount', 15, 4)->nullable()->default(0);
                $table->json('totals')->nullable()->default(null);
                $table->json('payments')->nullable()->default(null);
                $table->smallInteger('status')->nullable()->default(0);
                $table->smallInteger('type')->nullable()->default(null)->comment('1=>normal,2=>ach,echeck');
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
        Schema::dropIfExists('payments_histories');
    }
};
