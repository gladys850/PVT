<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanGuaranteeRetirementFundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_guarantee_retirement_funds', function (Blueprint $table) {
            $table->unsignedBigInteger('loan_id');
            $table->unsignedBigInteger('retirement_fund_average_id');
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
            $table->foreign('retirement_fund_average_id')->references('id')->on('retirement_fund_averages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_guarantee_retirement_funds');
    }
}
