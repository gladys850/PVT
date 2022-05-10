<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFunctionDateCutRefinancing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE FUNCTION public.date_cut_refinancing(
            id_loan bigint)
            RETURNS date
            LANGUAGE 'plpgsql'
            COST 100
            VOLATILE PARALLEL UNSAFE
        AS $$
            declare
            date_cut date;
            date_query date;
            parent_loan integer;
            begin
                date_query = (select date_cut_refinancing from sismus sis where sis.loan_id = id_loan);
                if (date_query is not null)
                then
                    date_cut = date_query;
                else
                    parent_loan = (select parent_loan_id from loans l where l.id = id_loan);
                    date_query = (select estimated_date
                                    from loan_payments lp
                                    where state_id = (select id
                                                    from loan_payment_states lps 
                                                    where lps.name = 'Pendiente por confirmar' limit 1 offset 0)
                                    and lp.loan_id = parent_loan
                                    order by lp.quota_number, lp.created_at desc
                                    limit 1 offset 0);
                    if (parent_loan is not null and date_query is not null)
                    then
                        date_cut = date_query;
                    end if;
                end if;
                return date_cut;
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
        DB::statement("DROP FUNCTION date_cut_refinancing");
    }
}
