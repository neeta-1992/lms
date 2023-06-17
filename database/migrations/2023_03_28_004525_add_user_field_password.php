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
        /* if (Schema::hasTable('users')) { */
            Schema::table('users', function (Blueprint $table) {
              if (!Schema::hasColumn('users', 'old_passwords')) {
                  $table->text('old_passwords')->nullable()->default(null)->after('password');
              }
              if (!Schema::hasColumn('users', 'password_expiry')) {
                  $table->date('password_expiry')->nullable()->default(null)->after('old_passwords');
              }
            });
       /*  } */



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
