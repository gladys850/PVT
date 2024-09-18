<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class AddProcedureLoansPartialPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE FUNCTION public.loans_partial_payments(
            input_date character varying
        )
        RETURNS SETOF json 
        LANGUAGE plpgsql    
        AS $$
        BEGIN
            RETURN QUERY
            SELECT 
                json_build_object(
                    'nup_affiliate', l.affiliate_id,
                    'matricula_affiliate', aff.registration,
                    'ci_affiliate', aff.identity_card,
                    'exp_ci_affiliate', cit.first_shortened,
                    'full_name_affiliate', concat_full_name(aff.first_name, aff.second_name, aff.last_name, aff.mothers_last_name, aff.surname_husband),
                    'matricula_borrower', lbo.registration,
                    'ci_borrower', lbo.identity_card,
                    'exp_ci_borrower', citb.first_shortened,
                    'full_name_borrower', concat_full_name(lbo.first_name, lbo.second_name, lbo.last_name, lbo.mothers_last_name, lbo.surname_husband),
                    'category_borrower', clb.name,
                    'degree_borrower', dlb.shortened,
                    'cell_number_borrower_one', regexp_replace((string_to_array(lbo.cell_phone_number, ','))[1], '[^0-9]', '', 'g'),
                    'cell_number_borrower_two', regexp_replace((string_to_array(lbo.cell_phone_number, ','))[2], '[^0-9]', '', 'g'),
                    'phone_number_borrower', regexp_replace(lbo.phone_number, '[^0-9]', '', 'g'),
                    'city_borrower', citb.name,
                    'address_borrower', adb.description,
                    'code_loan', l.code,
                    'disbursement_date_loan', to_char(l.disbursement_date, 'DD/MM/YYYY HH24:MI:SS'),
                    'loan_term_loan', l.loan_term,
                    'annual_interest_loan', lin.annual_interest,
                    'payment_kardex_cut_date', to_char(input_date::date, 'DD/MM/YYYY'),
                    'type_pay_kardex', pmk.shortened,
                    'estimated_quota_loan', lp.total_amount,
                    'balance_kardex_loan', p.balance_difference,
                    'payment_plan_cut_date', to_char(input_date::date, 'DD/MM/YYYY'),
                    'balance_plan_payment', lp.balance_real,
                    'state_affiliate', ast.name,
                    'modality_loan', ptl.second_name,
                    'sub_modality_loan', pml.shortened
                ) AS result
            FROM 
                loans l
            -- Obtener el último registro de loan_plan_payments
            LEFT JOIN LATERAL (
                SELECT 
                    quota_number,
                    CASE 
                        WHEN 
                        EXTRACT(YEAR FROM estimated_date) = EXTRACT(YEAR FROM input_date::date) AND
                        EXTRACT(MONTH FROM estimated_date) = EXTRACT(MONTH FROM input_date::date)
                        THEN balance
                        ELSE 0
                    END AS balance_real,
                    estimated_date,
                    total_amount
                FROM 
                    loan_plan_payments
                WHERE 
                    loan_id = l.id AND
                    estimated_date <= input_date::date AND
                    deleted_at is NULL
                ORDER BY 
                    estimated_date DESC
                LIMIT 1
            ) lp ON true
            -- Obtener el último registro de loan_payments
            LEFT JOIN LATERAL (
                SELECT
                    quota_number,
                    previous_balance,
                    estimated_date,
                    procedure_modality_id,
                    ROUND((previous_balance::numeric - capital_payment::numeric), 2) AS balance_difference
                FROM 
                    loan_payments
                WHERE
                    (state_id = 4 OR state_id = 3) AND
                    loan_id = l.id AND 
                    estimated_date <= input_date::date AND
                    deleted_at is NULL
                ORDER BY 
                    estimated_date DESC
                LIMIT 1
            ) p ON true
            --Affiliate
            LEFT JOIN affiliates aff ON aff.id = l.affiliate_id
            LEFT JOIN cities cit ON aff.city_identity_card_id = cit.id
            LEFT JOIN affiliate_states afs ON aff.affiliate_state_id = afs.id
            LEFT JOIN affiliate_state_types ast ON afs.affiliate_state_type_id = ast.id
            --Borrower
            LEFT JOIN loan_borrowers lbo ON l.id = lbo.loan_id
            LEFT JOIN cities citb ON lbo.city_identity_card_id = citb.id
            LEFT JOIN categories clb ON lbo.category_id = clb.id
            LEFT JOIN degrees dlb ON lbo.degree_id = dlb.id
            LEFT JOIN addresses adb ON lbo.address_id = adb.id AND adb.city_address_id = citb.id
            --Interest
            LEFT JOIN loan_interests lin ON l.interest_id = lin.id
            --Ultimo Pago
            LEFT JOIN procedure_modalities pmk ON pmk.id = p.procedure_modality_id
            --Préstamo
            LEFT JOIN procedure_modalities pml ON pml.id = l.procedure_modality_id
            LEFT JOIN procedure_types ptl ON pml.procedure_type_id = ptl.id
            WHERE 
                l.state_id = 3 AND
                p.balance_difference > lp.balance_real
            ORDER BY 
                l.id;
        END;
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
            DROP FUNCTION loans_partial_payments;");
    }
}
