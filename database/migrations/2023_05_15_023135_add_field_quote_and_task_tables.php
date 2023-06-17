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
        /* Quote Version Tables */
     /*   if (Schema::hasTable('quote_versions')) { */
            Schema::table('quote_versions', function (Blueprint $table) {
                if (!Schema::hasColumn('quote_versions', 'agent_signature')) {
                    $table->boolean('agent_signature')->nullable()->default(false)->after('insured_signature_date');
                }
                if (!Schema::hasColumn('quote_versions', 'isnured_signature')) {
                    $table->boolean('isnured_signature')->nullable()->default(false)->after('agent_signature');
                }
                if (!Schema::hasColumn('quote_versions', 'underwriting_informations')) {
                    $table->text('underwriting_informations')->nullable()->default(null)->after('isnured_signature');
                }
            });
       /*   } */


      /*   if (Schema::hasTable('tasks')) { */
            Schema::table('tasks', function (Blueprint $table) {
               /*  if (!Schema::hasColumn('tasks', 'type')) {
                   $table->string('type')->nullable()->default(null)->after('show_task');
                } */
                if (!Schema::hasColumn('tasks', 'type_id')) {
                    $table->uuid('type_id')->nullable()->default(null)->after('type');
                }
                if (!Schema::hasColumn('tasks', 'accept_assign_user')) {
                    $table->uuid('accept_assign_user')->nullable()->default(null)->after('type_id');
                }
                if (!Schema::hasColumn('tasks', 'user_type')) {
                    $table->string('user_type')->nullable()->default(null)->after('accept_assign_user');
                }
            });
        /*  } */


         /* if (Schema::hasTable('quotes')) { */
            Schema::table('quotes', function (Blueprint $table) {

                /*  if (!Schema::hasColumn('quotes', 'unlock_cancel')) {
                   $table->boolean('unlock_cancel')->nullable()->default(false)->after('type_id');
                } */
                if (!Schema::hasColumn('quotes', 'unlock_request')) {
                   $table->boolean('unlock_request')->nullable()->default(false)->after('status');
                }

                if (!Schema::hasColumn('quotes', 'finance_company')) {
                    $table->uuid('finance_company')->nullable()->default(null)->after('rate_table');
                }
                if (!Schema::hasColumn('quotes', 'decline_reason')) {
                    $table->text('decline_reason')->nullable()->default(null)->after('finance_company');
                }
                if (!Schema::hasColumn('quotes', 'aggregate_limit_approve')) {
                    $table->integer('aggregate_limit_approve')->nullable()->default(0)->after('status');
                }
                if (!Schema::hasColumn('quotes', 'aggregate_limit_admin_user_id')) {
                    $table->uuid('aggregate_limit_admin_user_id')->nullable()->default(0)->after('aggregate_limit_approve');
                }
            });
       /*   }
 */
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
