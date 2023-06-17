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
        if(!Schema::hasTable('companies')){
            Schema::create('companies', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('user_id')->nullable()->comment('default Databse users table id')->default(0);
                $table->string('comp_name')->nullable()->default(null);
                $table->string('comp_domain_name')->nullable()->default(null);
                $table->string('comp_web_address')->nullable()->default(null);
                $table->string('comp_logo_url')->nullable()->default(null);
                $table->string('privacy_page_url')->nullable()->default(null);
                $table->string('comp_nav_back_color_hex')->nullable()->default(null);
                $table->string('comp_nav_back_color_rbg')->nullable()->default(null);
                $table->string('comp_nav_text_color_hex')->nullable()->default(null);
                $table->string('comp_nav_text_color_rbg')->nullable()->default(null);
                $table->string('comp_nav_hover_color_hex')->nullable()->default(null);
                $table->string('comp_nav_hover_color_rbg')->nullable()->default(null);
                $table->string('primary_address')->nullable()->default(null);
                $table->string('primary_address_city')->nullable()->default(null);
                $table->string('primary_address_state')->nullable()->default(null);
                $table->string('primary_address_zip')->nullable()->default(null);
                $table->string('primary_telephone')->nullable()->default(null);
                $table->string('alternate_telephone')->nullable()->default(null);
                $table->string('fax')->nullable()->default(null);
                $table->string('tin_select')->nullable()->default(null);
                $table->string('tin')->nullable()->default(null);
                $table->string('payment_coupons_address')->nullable()->default(null);
                $table->string('payment_coupons_city')->nullable()->default(null);
                $table->string('payment_coupons_state')->nullable()->default(null);
                $table->string('payment_coupons_zip')->nullable()->default(null);
                $table->string('comp_contact_name')->nullable()->default(null);
                $table->string('comp_contact_email')->nullable()->default(null);
                $table->string('office_location')->nullable()->default(null);
                $table->string('comp_licenses')->nullable()->default(null);
                $table->string('comp_state_licensed')->nullable()->default(null);
                $table->string('finace_comp_contact_agents')->nullable()->default(null);
                $table->string('finace_comp_contact_insureds')->nullable()->default(null);
                $table->string('date_format')->nullable()->default(null);
                $table->string('time_format')->nullable()->default(null);
                $table->string('us_time_zone')->nullable()->default(null);
                $table->string('e_signature')->nullable()->default(null);
                $table->integer('status')->nullable()->default(0);
                $table->json('agency_data')->nullable()->default(0);
                $table->smallInteger('type')->nullable()->default(0)->comment("0=>all,1=>GA' AFTER");
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
        Schema::dropIfExists('companies');
    }
};
