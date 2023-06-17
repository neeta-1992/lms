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
        if (!Schema::hasTable('entities')) {
            Schema::create('entities', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users');
                $table->string('name')->nullable()->default(null);
                $table->string('entity_name')->nullable()->default(null);
                $table->string('legal_name')->nullable()->default(null);
                $table->string('telephone')->nullable()->default(null);
                $table->string('tin')->nullable()->default(null);
                $table->string('fax')->nullable()->default(null);
                $table->string('license_state')->nullable()->default(null);
                $table->string('license_no')->nullable()->default(null);
                $table->string('licence_expiration_date')->nullable()->default(null);
                $table->string('email')->nullable()->default(null);
                $table->string('website')->nullable()->default(null);
                $table->string('address')->nullable()->default(null);
                $table->string('city')->nullable()->default(null);
                $table->string('state')->nullable()->default(null);
                $table->string('zip')->nullable()->default(null);
                $table->string('maximum_reinstate_allowed')->nullable()->default(null);
                $table->string('mailing_address')->nullable()->default(null);
                $table->string('mailing_city')->nullable()->default(null);
                $table->string('mailing_state')->nullable()->default(null);
                $table->string('mailing_zip')->nullable()->default(null);
                $table->string('sales_excustive')->nullable()->default(null);
                $table->string('sales_excustive_user')->nullable()->default(null);
                $table->json('other_fields')->nullable()->default(null);
                $table->string('tax_id')->nullable()->default(null);
                $table->string('down_payment_rule')->nullable()->default(null);
                $table->string('mailing_address_radio')->nullable()->default(null);
                $table->float('aggregate_limit')->nullable()->default(0);
                $table->smallInteger('entity_type')->nullable()->default(0);
                $table->smallInteger('status')->nullable()->default(0);
                $table->text('notes')->nullable()->default(null);
                if(config('database.default') !== "mysql"){
                    $table->integer('parent_id')->nullable()->default(null)->comment("Main Datatabase entities table id");
                }
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
        Schema::dropIfExists('entities');
    }
};
