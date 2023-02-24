<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProcedureModalitiesLoan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('procedure_types', function (Blueprint $table) {
            $table->softDeletes();
        });
        DB::statement("update procedure_modalities set is_valid = false where id in (51,52,53,54);");
        DB::statement("update procedure_types set deleted_at = '2023-02-23' where id in (14,15);");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
