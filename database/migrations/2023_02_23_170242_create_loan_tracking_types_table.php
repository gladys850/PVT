<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanTrackingTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_tracking_types', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sequence_number')->comment('orden de los tipos de seguimiento');
            $table->string('name')->comment('tipo de seguimiento de préstamos')->nullable();
            $table->boolean('is_valid')->default(true)->comment('campo para habilitar el tipo de seguimiento')->nullable();
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
        Schema::dropIfExists('loan_tracking_types');
    }
}
