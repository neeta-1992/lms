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
      /*   if (Schema::hasTable('quote_terms')) { */
            Schema::table('quote_terms', function (Blueprint $table) {
                if (!Schema::hasColumn('quote_terms', 'unearned_fees')) {
                    $table->decimal('unearned_fees', 15, 4)->nullable()->default(0)->after('effective_apr');
                }
                if (!Schema::hasColumn('quote_terms', 'earned_fees')) {
                    $table->decimal('earned_fees', 15, 4)->nullable()->default(0)->after('unearned_fees');
                }
            });
     /*    } */
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
