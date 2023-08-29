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
            $table->integer('channel_no');
            $table->string('sub_channel');
            $table->string('planted_on')->nullable();
            $table->string('current_stage')->nullable();
            $table->string('harvesting_date')->nullable();
            $table->string('pruning')->nullable();
            $table->string('staking')->nullable();
            $table->string('nutrition_addition')->nullable();
            $table->string('spray1')->nullable();
            $table->string('spray2')->nullable();
            $table->string('spray3')->nullable();
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
