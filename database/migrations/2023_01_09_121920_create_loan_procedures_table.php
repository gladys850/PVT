<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanProceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_procedures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->boolean('is_enable')->default(false);
            $table->date('start_production_date');
            $table->timestamps();
        });
    }

    /***
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_procedures');
    }
}
