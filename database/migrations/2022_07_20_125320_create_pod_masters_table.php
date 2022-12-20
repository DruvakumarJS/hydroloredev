<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePodMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pod_masters', function (Blueprint $table) {
            $table->id();
            $table->string('data_frame');
            $table->string('description');
            $table->string('unit');
            $table->string('range');
            $table->string('threshold');
            $table->string('min')->nullable();
            $table->string('max')->nullable();
            $table->string('x_value')->nullable();
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
        Schema::dropIfExists('pod_masters');
    }
}
