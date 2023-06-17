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
       /*   if (Schema::hasTable('users')) { */
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'entity_id')) {
                    $table->integer('entity_id')->nullable()->default(0)->after('company_id');
                }
                if (!Schema::hasColumn('users', 'inmail_service')) {
                    $table->integer('inmail_service')->nullable()->default(0)->after('email');
                }
                if (!Schema::hasColumn('users', 'fax')) {
                    $table->string('fax')->nullable()->default(null)->after('mobile');
                }
                if (!Schema::hasColumn('users', 'extenstion')) {
                    $table->string('extenstion')->nullable()->default(null)->after('mobile');
                }
                if (!Schema::hasColumn('users', 'alternate_telephone')) {
                    $table->string('alternate_telephone')->nullable()->default(null)->after('extenstion');
                }
                if (!Schema::hasColumn('users', 'alternate_telephone_extenstion')) {
                    $table->string('alternate_telephone_extenstion')->nullable()->default(null)->after('alternate_telephone');
                }
                if (!Schema::hasColumn('users', 'esignature')) {
                    $table->string('esignature')->nullable()->default(null)->after('alternate_telephone');
                }
                if (!Schema::hasColumn('users', 'owner_percent')) {
                     $table->string('owner_percent')->nullable()->default(null);
                }
                if (!Schema::hasColumn('users', 'role')) {
                   $table->integer('role')->nullable()->default(0)->comment("1=>admin,2=>user");
                }
                if (!Schema::hasColumn('users', 'owner')) {
                   $table->boolean('owner')->nullable()->default(false);
                }
                if (!Schema::hasColumn('users', 'office')) {
                   $table->boolean('office')->nullable()->default(false);
                }
                if (!Schema::hasColumn('users', 'email_information')) {
                   $table->text('email_information')->nullable()->default(null)->after('office');
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
        //
    }
};
