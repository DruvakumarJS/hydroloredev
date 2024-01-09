<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('issue');
            $table->string('tittle')->nullable();
            $table->string('description')->nullable();
            $table->text('solution')->nullable();
            $table->string('sensor_key')->nullable();
            $table->string('type');
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
        Schema::dropIfExists('sensor_notifications');
    }
}
