<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatabaseNameToLoanContributionAdjustsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('loan_contribution_adjusts', function (Blueprint $table) {
            $table->enum('database_name',['PVT','SISMU'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loan_contribution_adjusts', function (Blueprint $table) {
            //
        });
    }
}
