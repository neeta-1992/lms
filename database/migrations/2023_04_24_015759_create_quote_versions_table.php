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
        if (!Schema::hasTable('quote_versions')) {
            Schema::create('quote_versions', function (Blueprint $table) {
                $table->uuid('id')->primary()->unique();
                $table->integer('user_id')->unsigned()->nullable()->default(null);
                $table->string('quote_id')->nullable()->default(null);
                $table->integer('version_id')->nullable()->default(0);
                $table->uuid('quote_parent_id')->nullable()->default(null);
                $table->boolean('favourite')->nullable()->default(false);
                $table->string('document_id')->nullable()->default(null);
                $table->boolean('notice')->nullable()->default(0);
                $table->boolean('agent_sig_notice')->nullable()->default(0);
                $table->boolean('upload_signed_finance_agreement')->nullable()->default(0);
                $table->integer('attachment_signed_id')->unsigned()->nullable()->default(0);
                $table->integer('agent_insured_send_id')->unsigned()->nullable()->default(0);
                $table->uuid('insured_signature_id')->unsigned()->nullable()->default(0);
                $table->string('signature_key')->nullable()->default(null);
                $table->dateTime('insured_signature_date')->nullable()->default(null);
                $table->timestamps();
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
        Schema::dropIfExists('quote_versions');
    }
};
