<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsImportationQuantityAndImportationDateToLoanPaymentPeriods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loan_payment_periods', function (Blueprint $table) {
            $table->integer('importation_quantity')->nullable();
            $table->date('importation_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loan_payment_periods', function (Blueprint $table) {
            $table->dropColumn('importation_quantity');
            $table->dropColumn('importation_date');
        });
    }
}
