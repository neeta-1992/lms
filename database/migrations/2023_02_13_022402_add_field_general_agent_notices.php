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
        if(Schema::hasTable('general_agent_notices')){
            Schema::table('general_agent_notices', function (Blueprint $table) {
               if (!Schema::hasColumn('general_agent_notices', 'entity_id')) {
                    $table->integer('entity_id')->nullable()->default(0)->after('id');
               }

               if (!Schema::hasColumn('general_agent_notices', 'default_email_notices')) {
                    $table->integer('default_email_notices')->nullable()->default(0)->after('json');
               }
               if (!Schema::hasColumn('general_agent_notices', 'default_fax_notices')) {
                    $table->integer('default_fax_notices')->nullable()->default(0)->after('default_email_notices');
               }
               if (!Schema::hasColumn('general_agent_notices', 'default_mail_notices')) {
                     $table->string('default_mail_notices')->nullable()->default(0)->after('default_fax_notices');
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
        if(Schema::hasTable('general_agent_notices')){
            Schema::table('general_agent_notices', function (Blueprint $table) {
               if (Schema::hasColumn('general_agent_notices', 'entity_id')) {
                    $table->dropColumn('entity_id');
               }
            });
        }
    }
};
