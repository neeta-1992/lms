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
       if(Schema::hasTable('notice_templates')){
            Schema::table('notice_templates', function (Blueprint $table) {
               if (!Schema::hasColumn('notice_templates', 'notice_id')) {
                    $table->string('notice_id')->nullable()->default(null)->after('id');
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
       if(Schema::hasTable('notice_templates')){
            Schema::table('notice_templates', function (Blueprint $table) {
               if (Schema::hasColumn('notice_templates', 'notice_id')) {
                    $table->dropColumn('notice_id');
               }
            });
        }
    }
};
