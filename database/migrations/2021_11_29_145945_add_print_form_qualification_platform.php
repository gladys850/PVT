<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrintFormQualificationPlatform extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loan_modality_parameters', function (Blueprint $table) {
            $table->boolean('print_form_qualification_platform')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loan_modality_parameters', function (Blueprint $table) {
            $table->dropColumn('print_form_qualification_platform');
        });
    }
}
