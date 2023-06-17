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
        if(!Schema::hasTable('notice_templates')){
            Schema::create('notice_templates', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users');
                $table->string('name')->nullable()->default(null);
                $table->string('send_to')->nullable()->default(null);
                $table->string('action')->nullable()->default(null);
                $table->string('send_by')->nullable()->default(null);
                $table->string('template_type')->nullable()->default(null);
              /*   $table->integer('coverage_type')->nullable()->default(null); */
                $table->text('description')->nullable()->default(null);
                $table->time('schedule_time')->nullable()->default(null);
                $table->string('schedule_days')->nullable()->default(null);
                $table->string('subject')->nullable()->default(null);
                $table->boolean('status')->nullable()->default(false);
                $table->longText('template_text')->nullable()->default(null);
                if(config('database.default') !== "mysql"){
                    $table->integer('parent_id')->nullable()->default(null)->comment("Main Datatabase notice_templates table id");
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
        Schema::dropIfExists('notice_templates');
    }
};
