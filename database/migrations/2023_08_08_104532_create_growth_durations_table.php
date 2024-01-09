<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrowthDurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('growth_durations', function (Blueprint $table) {
            $table->id();
            $table->string('category_id');
            $table->string('crop_id');
            $table->string('seedling')->default('0');
            $table->string('seeding_image')->nullable();
            $table->string('young_plants')->default('0');
             $table->string('young_image')->nullable();
            $table->string('matured')->default('0');
             $table->string('matured_image')->nullable();
            $table->string('vegetative_phase')->default('0');
             $table->string('vegetative_image')->nullable();
            $table->string('flowering_stage')->default('0');
             $table->string('flowering_image')->nullable();
            $table->string('fruiting_stage')->default('0'); 
             $table->string('fruiting_image')->nullable();
            $table->string('harvesting')->default('0');
             $table->string('harvesting_image')->nullable();
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
        Schema::dropIfExists('growth_durations');
    }
}
