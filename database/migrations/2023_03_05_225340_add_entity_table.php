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
       /*   if (Schema::hasTable('entities')) { */
            Schema::table('entities', function (Blueprint $table) {
                if (!Schema::hasColumn('entities', 'agency')) {
                    $table->integer('agency')->nullable()->default(0)->after('id');
                }
                if (!Schema::hasColumn('entities', 'username')) {
                    $table->string('username')->nullable()->default(null)->after('agency');
                }
                if (!Schema::hasColumn('entities', 'rate_table')) {
                    $table->string('rate_table')->nullable()->default(null)->after('sales_excustive');
                }
                if (!Schema::hasColumn('entities', 'compensation_table')) {
                    $table->integer('compensation_table')->nullable()->default(0)->after('rate_table');
                }
                if (!Schema::hasColumn('entities', 'personal_maximum_finance_amount')) {
                    $table->string('personal_maximum_finance_amount')->nullable()->default(0)->after('compensation_table');
                }
                if (!Schema::hasColumn('entities', 'commercial_maximum_finance_amount')) {
                    $table->string('commercial_maximum_finance_amount')->nullable()->default(null)->after('personal_maximum_finance_amount');
                }
                if (!Schema::hasColumn('entities', 'year_established')) {
                    $table->string('year_established')->nullable()->default(null)->after('commercial_maximum_finance_amount');
                }
                if (!Schema::hasColumn('entities', 'non_resident_licenses')) {
                    $table->string('non_resident_licenses')->nullable()->default(null)->after('year_established');
                }
                if (!Schema::hasColumn('entities', 'upload_agency_ec_insurance')) {
                     $table->string('upload_agency_ec_insurance')->nullable()->default(null)->after('json');
                 }
                if (!Schema::hasColumn('entities', 'json')) {
                    $table->text('json')->nullable()->default(null)->after('parent_id');
                }
                if (!Schema::hasColumn('entities', 'e_signature')) {
                    $table->longText('e_signature')->nullable()->default(null)->after('json');
                }

                if (!Schema::hasColumn('entities', 'sales_organization')) {
                    $table->integer('sales_organization')->nullable()->default(0)->after('json');
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
