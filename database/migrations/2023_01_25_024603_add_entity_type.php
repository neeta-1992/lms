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

       if (Schema::hasTable('entities')) {
            Schema::table('entities', function (Blueprint $table) {
                 if (!Schema::hasColumn('entities', 'type')) {
                    $table->smallInteger('type')->nullable()->default(0)->comment('1=>insurance-company,2=>general-agents,3=>agency');
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
        if (Schema::hasTable('entities')) {
            Schema::table('entities', function (Blueprint $table) {
                if (Schema::hasColumn('entities', 'type')) {
                    $table->dropColumn('type');
                }
            });
        }
    }
};
