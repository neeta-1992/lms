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
        if(!Schema::hasTable('company_email_settings')){
            Schema::create('company_email_settings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('company_id')->constrained('companies');
                $table->string('type')->nullable()->default(null);
                $table->string('email')->nullable()->default(null);
                $table->string('username')->nullable()->default(null);
                $table->string('outgoing_server')->nullable()->default(null);
                $table->string('passward')->nullable()->default(null);
                $table->string('authentication')->nullable()->default(null);
                $table->string('imap',100)->nullable()->default(null);
                $table->string('port',100)->nullable()->default(null);
                $table->string('smpt_secure',100)->nullable()->default(null);
                $table->softDeletes();
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
        Schema::dropIfExists('company_email_settings');
    }
};
