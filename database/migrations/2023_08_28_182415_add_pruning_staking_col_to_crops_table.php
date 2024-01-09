<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPruningStakingColToCropsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crops', function (Blueprint $table) {
            $table->string('pruning')->nullable();
            $table->string('pruning_steps')->nullable();
            $table->string('staking')->nullable();
            $table->string('staking_steps')->nullable();
            $table->string('nutrients_addition_steps')->nullable();
            $table->string('spray1_steps')->nullable();
            $table->string('spray2_steps')->nullable();
            $table->string('spray3_steps')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crops', function (Blueprint $table) {
            //
        });
    }
}
