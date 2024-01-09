<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtpColToUserdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('userdetails', function (Blueprint $table) {
            $table->string('otp_verified')->default('0');
            $table->string('is_loggedin')->default('0');
            $table->string('last_seen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('userdetails', function (Blueprint $table) {
            //
        });
    }
}
