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
        if(!Schema::hasTable('states')){
             Schema::create('states', function (Blueprint $table) {
                $table->id();
                $table->string('state')->nullable()->default(null);
                $table->string('short_name')->nullable()->default(null);
                $table->string('region')->nullable()->default(null);
                $table->string('relativity')->nullable()->default(null);
                $table->string('tax')->nullable()->default(null);
                $table->string('is_enabled')->nullable()->default(null);
                $table->string('filing_fee')->nullable()->default(null);
                $table->string('filing_fee_type')->nullable()->default(null);
                $table->string('service_fee')->nullable()->default(null);
                $table->string('service_fee_type')->nullable()->default(null);
                $table->string('stamping_fee')->nullable()->default(null);
                $table->string('stamping_fee_type')->nullable()->default(null);
                $table->string('transaction_fee')->nullable()->default(null);
                $table->string('transaction_fee_type')->nullable()->default(null);
                $table->string('inspection_fee')->nullable()->default(null);
                $table->string('multi_inspection_fee')->nullable()->default(null);
                $table->text('surplusline_notices')->nullable()->default(null);
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
        Schema::dropIfExists('states');
    }
};
