<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReharvestingColToGrowthDurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('growth_durations', function (Blueprint $table) {
            $table->string('re_harvestable_crop')->default('No');
            $table->string('re_harvesting_day')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('growth_durations', function (Blueprint $table) {
            //
        });
    }
}
