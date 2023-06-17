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
/*         if (Schema::hasTable('down_payment_rules')) { */
            Schema::table('down_payment_rules', function (Blueprint $table) {
                if (!Schema::hasColumn('down_payment_rules', 'round_down_payment')) {
                    $table->string('round_down_payment')->nullable()->default(null)->after('override_minimum_earned');
                 }
            });
        /* } */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('down_payment_rules', function (Blueprint $table) {
            //
        });
    }
};
