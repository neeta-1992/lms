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
              if (!Schema::hasColumn('logs', 'login_user_id')) {
                  $table->integer('login_user_id')->unsigned()->nullable()->default(0)->index();
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
        Schema::table('logs', function (Blueprint $table) {
            //
        });
    }
};
