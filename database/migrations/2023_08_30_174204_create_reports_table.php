<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('user_name');
            $table->string('mobile');
            $table->string('email');
            $table->string('category');
            $table->string('crop_id');
            $table->string('crop_name');
            $table->string('duration');
            $table->string('channel');
            $table->string('seeds_quantity');
            $table->string('planted_date')->nullable();
            $table->string('pruning_date')->nullable();
            $table->string('staking_date')->nullable();
            $table->string('nutrition_date')->nullable();
            $table->string('spray1_date')->nullable();
            $table->string('spray2_date')->nullable();
            $table->string('spray3_date')->nullable();
            $table->text('nutritions');
            $table->text('pesticides');
            $table->string('avg_ab');
            $table->string('avg_pod');
            $table->string('avg_tds');
            $table->string('avg_ph');
            $table->string('avg_nut');
            $table->string('harvesting_date');
            $table->string('expected_quantitiy');
            $table->string('actual_quantity');
            $table->string('grade1')->nullable();
            $table->string('grade2')->nullable();
            $table->string('grade3')->nullable();
            $table->string('status');
            $table->text('comments');
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
        Schema::dropIfExists('reports');
    }
}
