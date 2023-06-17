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
        
        if(!Schema::hasTable('payables')){
            Schema::create('payables', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('policy_id')->nullable()->default(null)->comment('quote policy table');
                $table->uuid('user_id')->nullable()->default(null)->comment('user table');
                $table->uuid('vendor')->nullable()->default(null)->comment('user table');
                $table->uuid('gl_account')->nullable()->default(null);
                $table->uuid('account_id')->nullable()->default(null);
                $table->string('payee_name')->nullable()->default(null);
                $table->string('reference_no')->nullable()->default(null);
                $table->decimal('totalamount', 20, 4)->nullable()->default(0);
                $table->date('due_date')->nullable()->default(null);
                $table->date('inception_date')->nullable()->default(null);
                $table->date('first_payment_due_date')->nullable()->default(null);
                $table->string('type', 100)->nullable()->default(null);
                $table->string('check_number', 50)->nullable()->default(null);
                $table->smallInteger('status')->nullable()->default(0)->comment('open=>1,complete=>2,void=>3,close=>4');
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
        Schema::dropIfExists('payables');
    }
};
