<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('sr_no');
            $table->string('subject');
            $table->string('status')->nullable();
            $table->string('user_id')->nullable();
            $table->string('hub_id')->nullable();
            $table->string('pod_id')->nullable();
            $table->string('threshold_value')->nullable();
            $table->string('current_value')->nullable();
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
        Schema::dropIfExists('tickets');
    }
}
