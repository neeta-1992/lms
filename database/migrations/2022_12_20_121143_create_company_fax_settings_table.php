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
        if(!Schema::hasTable('company_fax_settings')){
            Schema::create('company_fax_settings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('company_id')->constrained('companies');
                $table->string('fax_email')->nullable()->default(null);
                $table->string('forward_incoming_faxes')->nullable()->default(null);
                $table->string('outgoing_fax_numbers')->nullable()->default(null);
                $table->string('server_email')->nullable()->default(null);
                $table->string('server_email_domain')->nullable()->default(null);
                $table->string('signed_agreement_fax_one')->nullable()->default(null);
                $table->string('signed_agreement_fax_two')->nullable()->default(null);
                $table->string('attachment_fax_one')->nullable()->default(null);
                $table->string('attachment_fax_two')->nullable()->default(null);
                $table->string('can_spam_notice')->nullable()->default(null);
                $table->string('copy_right_notice')->nullable()->default(null);
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
        Schema::dropIfExists('company_fax_settings');
    }
};
