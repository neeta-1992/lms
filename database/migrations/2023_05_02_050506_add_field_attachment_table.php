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
        if (!Schema::hasTable('attachments')) {
            Schema::table('attachments', function (Blueprint $table) {
                if (!Schema::hasColumn('attachments', 'attachment_type')) {
                   $table->string('attachment_type')->nullable()->default(null)->after('type');
                }
                if (!Schema::hasColumn('attachments', 'v_id')) {
                   $table->uuid('v_id')->nullable()->default(null)->after('type_id');
                }
                if (!Schema::hasColumn('attachments', 'is_pfa')) {
                    $table->boolean('is_pfa')->nullable()->default(false)->after('attachment_type');
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
        //
    }
};
