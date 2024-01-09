<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('mobile');
            $table->string('email');
            $table->string('address');
            $table->string('type_of_building');
            $table->string('location')->nullable();
            $table->string('installation_date')->nullable();
            $table->string('no_of_channels')->nullable();
            $table->string('crops_id')->nullable();
            $table->string('crops_name')->nullable();
            $table->string('require_monitoring')->nullable();
            $table->string('comments')->nullable();
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
        Schema::dropIfExists('enquiries');
    }
}
