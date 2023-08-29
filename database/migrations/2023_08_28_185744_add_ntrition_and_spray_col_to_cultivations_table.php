<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNtritionAndSprayColToCultivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cultivations', function (Blueprint $table) {
            $table->string('pruning')->nullable();
            $table->string('staking')->nullable();
            $table->string('nutrition_addition')->nullable();
            $table->string('spray1')->nullable();
            $table->string('spray2')->nullable();
            $table->string('spray3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cultivations', function (Blueprint $table) {

        });
    }
}
