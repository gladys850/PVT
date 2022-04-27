<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFunctionConcatFullName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE FUNCTION public.concat_full_name(
            first_name character varying,
            second_name character varying,
            last_name character varying,
            mothers_last_name character varying,
            surname_husband character varying)
            RETURNS text
            LANGUAGE 'plpgsql'
            COST 100
            VOLATILE PARALLEL UNSAFE
        AS $$
                        declare
                        full_name text; 
                        begin
                            full_name = trim(replace(replace(
                                (coalesce(trim(first_name), '') || ' ' ||
                                 coalesce(trim(second_name), '') || ' ' ||
                                 coalesce(trim(last_name), '')|| ' ' ||
                                 coalesce(trim(mothers_last_name), '')|| ' ' ||
                                 coalesce(trim(surname_husband), ''))
                                ,'  ',' '),'  ',' '));
                                    
                                if full_name = '' then return null;
                                else return upper(full_name); end if;
                        END
                        
                
        $$;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('function_concat_full_name');
    }
}
