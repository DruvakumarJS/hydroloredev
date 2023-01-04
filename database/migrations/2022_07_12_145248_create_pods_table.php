<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pods', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('pod_id');
            $table->string('hub_id');
            $table->string('status')->nullable();
            $table->string('location');
            $table->string('dimention')->nullable();
            $table->string('polyhouses')->nullable();
            $table->string('Date')->nullable();
            $table->string('Time')->nullable();
            $table->string('AB_T1')->nullable();
            $table->string('AB_H1')->nullable();
            $table->string('POD_T1')->nullable();
            $table->string('POD_H1')->nullable();
            $table->string('TDS_V1')->nullable();
            $table->string('PH_V1')->nullable();
            $table->string('NUT_T1')->nullable();
            $table->string('NP_I1')->nullable();
            $table->string('SV_I1')->nullable();
            $table->string('BAT_V1')->nullable();
            $table->string('FLO_V1')->nullable();
            $table->string('FLO_V2')->nullable();
            $table->string('STS_PSU')->nullable();
            $table->string('STS_NP1')->nullable();
            $table->string('STS_NP2')->nullable();
            $table->string('STS_SV1')->nullable();
            $table->string('STS_SV2')->nullable();
            $table->string('WL1H')->nullable();
            $table->string('WL1L')->nullable();
            $table->string('WL2H')->nullable();
            $table->string('WL2L')->nullable();
            $table->string('WL3H')->nullable();
            $table->string('WL3L')->nullable();
            $table->string('RL1')->nullable();
            $table->string('RL2')->nullable();
            $table->string('RL3')->nullable();
            $table->string('RL4')->nullable();
            $table->string('RL5')->nullable();
            $table->string('PMODE')->nullable();
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
        Schema::dropIfExists('pods');
    }
}
