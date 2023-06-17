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
        if(!Schema::hasTable('coverage_types')){
            Schema::create('coverage_types', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('user_id')->unsigned()->index()->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->string('name')->nullable()->default(null);
                $table->string('account_type')->nullable()->default(null);
                $table->string('account_active')->nullable()->default(null);
                $table->integer('cancel_terms')->unsigned()->nullable()->default(0);
                if(config('database.default') !== "mysql"){
                    $table->integer('parent_id')->nullable()->default(null)->comment("Main Datatabase coverage_types table id");
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
        Schema::dropIfExists('coverage_types');
    }
};
