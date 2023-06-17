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
          if(!Schema::hasTable('logs')){
            Schema::create('logs', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id')->unsigned()->nullable()->default(0);
                $table->integer('type_id')->unsigned()->nullable()->default(0);
                $table->string('type')->nullable()->default(null);
                $table->longText('message')->nullable()->default(null);
                $table->string('ip')->nullable()->default(null);
                $table->string('country')->nullable()->default(null);
                $table->integer('company_id')->unsigned()->nullable()->default(0);
                $table->string('system')->nullable()->default(null);
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
        Schema::dropIfExists('logs');
    }
};
