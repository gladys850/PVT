<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanGuaranteeRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_guarantee_registers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('loan_id')->nullable();
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
            $table->unsignedBigInteger('affiliate_id')->unsigned();
            $table->foreign('affiliate_id')->references('id')->on('affiliates');
            $table->morphs('guarantable');
            $table->float('amount',10,2)->default(0);  // monto de ajuste al liquido para calificacion
            $table->date('period_date');// Fecha del periodo de la boleta
            $table->enum('database_name',['PVT','SISMU'])->nullable();
            $table->string('loan_code_guarantee')->nullable();
            $table->string('description')->nullable();// Descripcion por lo que se realiza el ajuste
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
        Schema::dropIfExists('loan_guarantee_registers');
    }
}
