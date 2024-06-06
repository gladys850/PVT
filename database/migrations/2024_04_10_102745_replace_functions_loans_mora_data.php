<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplaceFunctionsLoansMoraData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE FUNCTION public.loans_mora_data(
                final_date character varying)
                RETURNS SETOF json 
                LANGUAGE 'plpgsql'    
            AS $$
                begin
                    return query
                    select json_agg(to_json(loans_mora)) from
                    (   select 
                            l.id,
                            llm.type_mora as type,
                            -- AFFILIATE
                            vlb.id_affiliate, vlb.registration_affiliate, vlb.identity_card_affiliate, vlb.city_exp_first_shortened_affiliate, vlb.full_name_affiliate
                            -- BORROWER
                            ,vlb.registration_borrower, vlb.identity_card_borrower, vlb.city_exp_first_shortened_borrower, vlb.full_name_borrower
                            ,(select to_json(ph) from (select string_to_array(lb.phone_number,',') number) ph) as phone
                            ,(select to_json(cell) from (select string_to_array(lb.cell_phone_number,',') number) cell) as cell_phone
                            --ADDRESS
                            ,(select json_agg(to_json(ad)) from (
                                select ct.name, ad.zone, ad.street, ad.number_address, ad.description
                                from addresses ad, cities ct
                                where lb.address_id = ad.id and ad.city_address_id = ct.id
                            ) ad) as address
                            -- LOAN 
                            ,l.code, l.disbursement_date, l.loan_term
                            ,li.annual_interest, (select lpv.estimated_date from last_payment_validated(l.id) lpv) ,(select pm2.shortened from last_payment_validated(l.id) lpv2, procedure_modalities pm2 where pm2.id = lpv2.procedure_modality_id)
                            ,estimated_quota(l.id),balance_loan(l.id) as balance
                            ,ast.name, pt.second_name, pm.shortened as sub_modality
                            ,days_mora(l.id, final_date::date, llm.type_mora) as days_mora
                            -- PERSONA DE REFERENCIA
                            ,(select json_agg(to_json(r)) from (
                                select concat_full_name(pr.first_name, pr.second_name, pr.last_name, pr.mothers_last_name, pr.surname_husband) as full_name, pr.phone_number, pr.cell_phone_number, pr.address
                                from loan_persons lp, personal_references pr
                                where lp.loan_id = l.id and lp.personal_reference_id = pr.id
                            ) r) as reference
                            -- GARANTES
                            ,(select json_agg(to_json(grt)) from (
                                select vlg.registration_affiliate, vlg.identity_card_affiliate
                                        ,vlg.city_exp_first_shortened_affiliate, vlg.full_name_affiliate
                                        ,vlg.registration_guarantor, vlg.identity_card_guarantor
                                        ,vlg.city_exp_first_shortened_guarantor, vlg.full_name_guarantor
                                        ,lg.phone_number, (select to_json(cellg) from (select string_to_array(lg.cell_phone_number,',') number) cellg) as cell_phone
                                        ,(select ast2.name 
                                          from affiliate_states as2, affiliate_state_types ast2 
                                          where as2.affiliate_state_type_id = ast2.id 
                                            and lg.affiliate_state_id = as2.id)
                                from view_loan_guarantors vlg
                                join loan_guarantors lg on lg.affiliate_id = vlg.id_affiliate
                                where vlg.id_loan = l.id and l.id = lg.loan_id
                            ) grt) as guarantors
            
                        from list_loans_mora(final_date::date) llm
                                , view_loan_borrower vlb, loan_borrowers lb, loans l, loan_interests li
                                , affiliate_states afs, affiliate_state_types ast, procedure_modalities pm, procedure_types pt
                     
                        where   llm.loan_id = l.id
                                and vlb.id_loan = lb.loan_id
                                and l.id = vlb.id_loan
                                and li.id = l.interest_id
                                and	afs.id = lb.affiliate_state_id
                                and ast.id = afs.affiliate_state_type_id
                                and pm.id = l.procedure_modality_id
                                and pm.procedure_type_id = pt.id
                        order by l.code
                   ) loans_mora;
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
        DB::statement("
            DROP FUNCTION loans_mora_data;");
    }
}
