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
            Schema::table('companies', function (Blueprint $table) {
                if (!Schema::hasColumn('companies', 'final_approval')) {
                    $table->boolean('final_approval')->nullable()->default(false)->after('type');
                }
                if (!Schema::hasColumn('companies', 'final_approval_users')) {
                    $table->string('final_approval_users')->nullable()->default(false)->after('final_approval');
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
        Schema::table('companies', function (Blueprint $table) {
            //
        });
    }
};
