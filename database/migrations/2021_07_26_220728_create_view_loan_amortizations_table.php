<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewLoanAmortizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE VIEW public.view_loan_amortizations
        AS
        SELECT l.id AS id_loan,
           l.code AS code_loan,
           l.disbursement_date AS disbursement_date_loan,
           l.amount_approved AS amount_approved_loan,
           ptl.name AS procedure_type_loan,
           li.annual_interest AS annual_interest_loan,
           lp.state_affiliate AS state_affiliate_loan_payment,
           lp.id AS id_loan_payment,
           lp.code AS code_loan_payment,
           lp.estimated_date AS estimated_date_loan_payment,
           lp.loan_payment_date AS date_loan_payment,
           lp.estimated_quota AS quota_loan_payment,
           lp.voucher AS voucher_loan_payment,
           lps.name AS states_loan_payment,
           la.type AS type_loan_payment,
           vt.name AS voucher_type_loan_payment,
           v.code AS code_voucher,
           a.first_name AS first_name_affiliate,
           a.second_name AS second_name_affiliate,
           a.last_name AS last_name_affiliate,
           a.mothers_last_name AS mothers_last_name_affiliate,
           a.surname_husband AS surname_husband_affiliate,
           a.identity_card AS identity_card_affiliate,
           a.registration AS registration_affiliate,
           concat_full_name(a.first_name, a.second_name, a.last_name, a.mothers_last_name, a.surname_husband) AS full_name_affiliate,
           a.first_name AS first_name_borrower,
           a.second_name AS second_name_borrower,
           a.last_name AS last_name_borrower,
           a.mothers_last_name AS mothers_last_name_borrower,
           a.surname_husband AS surname_husband_borrower,
           a.identity_card AS identity_card_borrower,
           a.registration AS registration_borrower,
           concat_full_name(a.first_name, a.second_name, a.last_name, a.mothers_last_name, a.surname_husband) AS full_name_borrower,
           as2.name AS state_affiliate,
           ast.name AS state_type_affiliate,
           pe.name AS pension_entity_affiliate,
           pm.name AS modality_loan_payment,
           pm.shortened AS modality_shortened_loan_payment,
           ls.name AS state_loan,
           lp.paid_by AS paid_by_loan_payment,
           pt.name AS procedure_loan_payment,
           lp.capital_payment,
           lp.penal_remaining,
           lp.penal_accumulated,
           lp.penal_payment,
           lp.interest_remaining,
           lp.interest_accumulated,
           lp.interest_payment,
           lp.previous_balance,
           lp.previous_balance - lp.capital_payment AS current_balance,
           lpc.name AS name_category,
           lpc.shortened AS shortened_category,
           lpc.type_register AS type_register_category
          FROM loan_payments lp
            JOIN loans l ON l.id = lp.loan_id
            JOIN loan_states ls ON ls.id = l.state_id
            JOIN procedure_modalities pml ON pml.id = l.procedure_modality_id
            JOIN procedure_types ptl ON ptl.id = pml.procedure_type_id
            JOIN loan_interests li ON li.id = l.interest_id
            JOIN affiliates a ON a.id = lp.affiliate_id
            JOIN affiliate_states as2 ON a.affiliate_state_id = as2.id
            JOIN affiliate_state_types ast ON as2.affiliate_state_type_id = ast.id
            LEFT JOIN pension_entities pe ON a.pension_entity_id = pe.id
            JOIN loan_affiliates la ON la.affiliate_id = a.id
            JOIN procedure_modalities pm ON pm.id = lp.procedure_modality_id
            JOIN procedure_types pt ON pt.id = pm.procedure_type_id
            JOIN loan_payment_states lps ON lps.id = lp.state_id
            JOIN loan_payment_categories lpc ON lpc.id = lp.categorie_id
            LEFT JOIN vouchers v ON v.payable_id = lp.id
            LEFT JOIN voucher_types vt ON vt.id = v.voucher_type_id
         WHERE la.type::text = 'affiliates'::text
       UNION
        SELECT l.id AS id_loan,
           l.code AS code_loan,
           l.disbursement_date AS disbursement_date_loan,
           l.amount_approved AS amount_approved_loan,
           ptl.name AS procedure_type_loan,
           li.annual_interest AS annual_interest_loan,
           lp.state_affiliate AS state_affiliate_loan_payment,
           lp.id AS id_loan_payment,
           lp.code AS code_loan_payment,
           lp.estimated_date AS estimated_date_loan_payment,
           lp.loan_payment_date AS date_loan_payment,
           lp.estimated_quota AS quota_loan_payment,
           lp.voucher AS voucher_loan_payment,
           lps.name AS states_loan_payment,
           la.type AS type_loan_payment,
           vt.name AS voucher_type_loan_payment,
           v.code AS code_voucher,
           a.first_name AS first_name_affiliate,
           a.second_name AS second_name_affiliate,
           a.last_name AS last_name_affiliate,
           a.mothers_last_name AS mothers_last_name_affiliate,
           a.surname_husband AS surname_husband_affiliate,
           a.identity_card AS identity_card_affiliate,
           a.registration AS registration_affiliate,
           concat_full_name(a.first_name, a.second_name, a.last_name, a.mothers_last_name, a.surname_husband) AS full_name_affiliate,
           s.first_name AS first_name_borrower,
           s.second_name AS second_name_borrower,
           s.last_name AS last_name_borrower,
           s.mothers_last_name AS mothers_last_name_borrower,
           s.surname_husband AS surname_husband_borrower,
           s.identity_card AS identity_card_borrower,
           s.registration AS registration_borrower,
           concat_full_name(s.first_name, s.second_name, s.last_name, s.mothers_last_name, s.surname_husband) AS full_name_borrower,
           as2.name AS state_affiliate,
           ast.name AS state_type_affiliate,
           pe.name AS pension_entity_affiliate,
           pm.name AS modality_loan_payment,
           pm.shortened AS modality_shortened_loan_payment,
           ls.name AS state_loan,
           lp.paid_by AS paid_by_loan_payment,
           pt.name AS procedure_loan_payment,
           lp.capital_payment,
           lp.penal_remaining,
           lp.penal_accumulated,
           lp.penal_payment,
           lp.interest_remaining,
           lp.interest_accumulated,
           lp.interest_payment,
           lp.previous_balance,
           lp.previous_balance - lp.capital_payment AS current_balance,
           lpc.name AS name_category,
           lpc.shortened AS shortened_category,
           lpc.type_register AS type_register_category
          FROM loan_payments lp
            JOIN loans l ON l.id = lp.loan_id
            JOIN procedure_modalities pml ON pml.id = l.procedure_modality_id
            JOIN procedure_types ptl ON ptl.id = pml.procedure_type_id
            JOIN loan_interests li ON li.id = l.interest_id
            JOIN loan_states ls ON ls.id = l.state_id
            JOIN affiliates a ON a.id = lp.affiliate_id
            JOIN affiliate_states as2 ON a.affiliate_state_id = as2.id
            JOIN affiliate_state_types ast ON as2.affiliate_state_type_id = ast.id
            LEFT JOIN pension_entities pe ON a.pension_entity_id = pe.id
            JOIN loan_affiliates la ON la.affiliate_id = a.id
            JOIN procedure_modalities pm ON pm.id = lp.procedure_modality_id
            JOIN procedure_types pt ON pt.id = pm.procedure_type_id
            JOIN loan_payment_states lps ON lps.id = lp.state_id
            JOIN spouses s ON s.affiliate_id = a.id
            JOIN loan_payment_categories lpc ON lpc.id = lp.categorie_id
            LEFT JOIN vouchers v ON v.payable_id = lp.id
            LEFT JOIN voucher_types vt ON vt.id = v.voucher_type_id
         WHERE la.type::text = 'spouses'::text;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_loan_amortizations");
    }
}
