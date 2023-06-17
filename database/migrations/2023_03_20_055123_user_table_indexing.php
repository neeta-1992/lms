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
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'first_name')) {
                    $table->index('first_name');
                }

                if (Schema::hasColumn('users', 'last_name')) {
                    $table->index('last_name');
                }

                if (Schema::hasColumn('users', 'email')) {
                    $table->index('email');
                }
                if (Schema::hasColumn('users', 'user_type')) {
                   $table->index('user_type');
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
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
