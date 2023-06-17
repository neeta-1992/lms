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
        if (!Schema::hasTable('messages')) {
            Schema::create('messages', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('from_id')->nullable()->default(null);
                $table->string('to_id')->nullable()->default(null);
                $table->string('subject')->nullable()->default(null);
                $table->string('cc')->nullable()->default(null);
                $table->longText('message')->nullable()->default(null);
                $table->boolean('important')->nullable()->default(false);
                $table->boolean('sent_important')->nullable()->default(false);
                $table->boolean('read')->nullable()->default(false);
                $table->uuid('parent_id')->nullable()->default(false);
                $table->string('type')->nullable()->default(0)->comment('0=>inbox,1=>reply,2=>Forward');
                $table->integer('is_delete')->nullable()->default(0);
                $table->softDeletes();
                $table->timestamps();
            });
        }
         Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('is_delete');
          
            $table->integer('is_delete')->nullable()->default(0)->after('type');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
