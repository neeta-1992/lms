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
        if (Schema::hasTable('companies')) {
            Schema::table('companies', function (Blueprint $table) {
                if (!Schema::hasColumn('companies', 'date_format_value')) {
                    $table->string('date_format_value')->nullable()->default(null)->after('date_format');
                }
                if (!Schema::hasColumn('companies', 'time_format_value')) {
                    $table->string('time_format_value')->nullable()->default(null)->after('time_format');
                }
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
        if (Schema::hasTable('companies')) {
            Schema::table('companies', function (Blueprint $table) {
                if (Schema::hasColumn('companies', 'date_format_value')) {
                    $table->dropColumn('date_format_value');
                }
                if (Schema::hasColumn('companies', 'time_format_value')) {
                     $table->dropColumn('time_format_value');
                }
            });
        }
    }
};
