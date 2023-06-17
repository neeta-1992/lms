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
        if (Schema::hasTable('logs')) {
            Schema::table('logs', function (Blueprint $table) {
                if (!Schema::hasColumn('logs', 'old_value')) {
                    $table->longText('old_value')->nullable()->default(null)->after('message');
                }

                if (!Schema::hasColumn('logs', 'new_value')) {
                    $table->longText('new_value')->nullable()->default(null)->after('old_value');
                }
            //
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
        Schema::table('logs', function (Blueprint $table) {
            //
        });
    }
};
