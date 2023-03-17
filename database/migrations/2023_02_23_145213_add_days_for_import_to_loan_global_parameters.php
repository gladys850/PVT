<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDaysForImportToLoanGlobalParameters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loan_global_parameters', function (Blueprint $table) {
            $table->unsignedTinyInteger('days_for_​import')->nullable()->comment('Días para la importación');
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
