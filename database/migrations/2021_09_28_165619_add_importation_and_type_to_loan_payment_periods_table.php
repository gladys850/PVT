<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImportationAndTypeToLoanPaymentPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loan_payment_periods', function (Blueprint $table) {
            $table->boolean('importation')->default(false)->nullable();
            $table->enum('importation_type',['COMANDO','SENASIR'])->nullable();
            $table->dropColumn(['import_command','import_senasir']);  
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
                 
        });
    }
}
