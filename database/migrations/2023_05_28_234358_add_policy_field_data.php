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
        /*   if (Schema::hasTable('companies')) { */
            Schema::table('quote_policies', function (Blueprint $table) {
                if (!Schema::hasColumn('quote_policies', 'effective_cancel_date')) {
                    $table->date('effective_cancel_date')->nullable()->default(null)->after('expiration_date');
                }
                if (!Schema::hasColumn('quote_policies', 'required_earning_interest')) {
                   $table->char('required_earning_interest', 4)->default(null)->after('effective_cancel_date');
                }
            });
      /*   } */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
