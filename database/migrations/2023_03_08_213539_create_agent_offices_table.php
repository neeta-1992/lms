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
        if (!Schema::hasTable('agent_offices')) {
            Schema::create('agent_offices', function (Blueprint $table) {
                $table->id();
                $table->foreignId('agency_id')->constrained('entities');
                $table->integer('user_id')->nullable()->default(0);
                $table->string('name')->nullable()->default(null);
                $table->string('email')->nullable()->default(null);
                $table->string('notes')->nullable()->default(null);
                $table->string('fax')->nullable()->default(null);
                $table->string('telephone')->nullable()->default(null);
                $table->string('address')->nullable()->default(null);
                $table->string('city')->nullable()->default(null);
                $table->string('state')->nullable()->default(null);
                $table->string('zip')->nullable()->default(null);
                $table->text('description')->nullable()->default(null);
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
        Schema::dropIfExists('agent_offices');
    }
};
