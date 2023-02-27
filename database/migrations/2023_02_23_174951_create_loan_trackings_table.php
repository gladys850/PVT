<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_trackings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('loan_id');
            $table->foreign('loan_id')->references('id')->on('loans');
            $table->bigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('loan_tracking_type_id');
            $table->foreign('loan_tracking_type_id')->references('id')->on('loan_tracking_types');
            $table->dateTime('tracking_date')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_trackings');
    }
}
