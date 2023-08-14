<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCultivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cultivations', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('pod_id');
            $table->string('crop_id');
            $table->string('category_id');
            $table->integer('chennel_no');
            $table->string('planted_on')->nullable();
            $table->string('current_stage')->nullable();
            $table->string('harvesting_date')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cultivations');
    }
}
