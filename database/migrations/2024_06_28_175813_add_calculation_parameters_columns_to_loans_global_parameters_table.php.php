<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCalculationParametersColumnsToLoansGlobalParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loan_global_parameters', function (Blueprint $table) {
            $table->float('numerator',10,6)->default(360);
            $table->float('denominator',10,6)->default(360);
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
            $table->dropColumn('numerator');
            $table->dropColumn('denominator');
        });
    }
}