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

        /* if (Schema::hasTable('messages')) { */
            Schema::table('messages', function (Blueprint $table) {
                if (!Schema::hasColumn('messages', 'qid')) {
                    $table->uuid('qid')->nullable()->default(null)->after('id');
                 }
                if (!Schema::hasColumn('messages', 'quote_subject')) {
                    $table->string('quote_subject')->nullable()->default(null)->after('subject');
                 }

                 if (!Schema::hasColumn('messages', 'vid')) {
                    $table->uuid('vid')->nullable()->default(null)->after('qid');
                 }

                 if (!Schema::hasColumn('messages', 'version')) {
                     $table->smallInteger('version')->nullable()->default(0)->after('vid');
                 }
            });
      /*   } */
       /*  if (Schema::hasTable('message_drafts')) { */
            Schema::table('message_drafts', function (Blueprint $table) {
                if (!Schema::hasColumn('message_drafts', 'qid')) {
                    $table->uuid('qid')->nullable()->default(null)->after('id');
                 }

                 if (!Schema::hasColumn('messages', 'quote_subject')) {
                    $table->string('quote_subject')->nullable()->default(null)->after('subject');
                 }

                 if (!Schema::hasColumn('message_drafts', 'vid')) {
                    $table->uuid('vid')->nullable()->default(null)->after('qid');
                 }

                 if (!Schema::hasColumn('message_drafts', 'version')) {
                     $table->smallInteger('version')->nullable()->default(0)->after('vid');
                 }
            });
        /* } */


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mail', function (Blueprint $table) {
            //
        });
    }
};
