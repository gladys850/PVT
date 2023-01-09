<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoanProcedureIdLoanGlobalParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loan_global_parameters', function (Blueprint $table) {
            $table->unsignedInteger('min_amount_fund_rotary')->change();
            $table->unsignedBigInteger('loan_procedure_id')->nullable();
            $table->foreign('loan_procedure_id')->references('id')->on('loan_procedures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loan_global_parameters', function (Blueprint $table) {
            //
        });
    }
}
