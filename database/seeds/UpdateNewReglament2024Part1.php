<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateNewReglament2024Part1 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        try {

            DB::statement('SELECT setval(\'loan_procedures_id_seq\', (SELECT COALESCE(MAX(id), 0) FROM loan_procedures))');
            DB::statement('SELECT setval(\'loan_global_parameters_id_seq\', (SELECT COALESCE(MAX(id), 0) FROM loan_global_parameters))');
            DB::statement('SELECT setval(\'procedure_types_id_seq\', (SELECT COALESCE(MAX(id), 0) FROM procedure_types))');
            DB::statement('SELECT setval(\'procedure_modalities_id_seq\', (SELECT COALESCE(MAX(id), 0) FROM procedure_modalities))');
            DB::statement('SELECT setval(\'loan_interests_id_seq\', (SELECT COALESCE(MAX(id), 0) FROM loan_interests))');

            //INHABILITACION DEL ANTIGUO REGLAMENTO 2024 TABLA loan_procedures
            DB::table('loan_procedures')->where('id', '2')->update([
                'is_enable' => false,
            ]);
            //CREACION DEL NUEVO REGLAMENTO EN TABLA loan_procedures Y PONIENDOLO ACTIVO
            DB::table('loan_procedures')->insert([
                [
                    'description' => 'Reglamento de Préstamos 2024',
                    'is_enable' => true,
                    'start_production_date' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //CREACION DE PARAMETROS GLOBALES DEL NUEVO REGLAMENTO TABLA loan_global_parameters
            DB::table('loan_global_parameters')->insert([
                [
                    'offset_ballot_day' => 7,
                    'offset_interest_day' => 15,
                    'livelihood_amount' => 0,
                    'min_service_years' => 0,
                    'min_service_years_adm' => 0,
                    'max_guarantor_active' => 3,
                    'max_guarantor_passive' => 2,
                    'date_delete_payment' => 1,
                    'max_loans_active' => 2,
                    'max_loans_process' => 1,
                    'days_current_interest' => 31,
                    'grace_period' => 3,
                    'consecutive_manual_payment' => 3,
                    'max_months_go_back' => 3,
                    'min_percentage_paid' => 25,
                    'min_remaining_installments' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'min_amount_fund_rotary' => 100000,
                    'loan_procedure_id' => 3,            //ID DEL NUEVO REGLAMENTO
                    'days_year_calculated' => 1,         //preguntar no existe en el documento base
                    'days_for_​import' => 20,             //preguntar no existe en el documento base
                    'numerator' => 360,                   //NUEVO
                    'denominator' => 360,                 //NUEVO
                ]
            ]);
            //Creación de Modalidades en la tabla procedure_types
            DB::table('procedure_types')->insert([
                [
                    'module_id' => 6,
                    'name' => 'Reprogramación Préstamo a Corto Plazo',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'second_name' => 'Rep. Corto Plazo',                        // no se tiene registro de este dato
                ],
                [
                    'module_id' => 6,
                    'name' => 'Reprogramación del Refinanciamiento Préstamo a Corto Plazo',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'second_name' => 'Rep. Ref. Corto Plazo',                   // no se tiene registro de este dato
                ],
                [
                    'module_id' => 6,
                    'name' => 'Reprogramación Préstamo a Largo Plazo',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'second_name' => 'Rep. Largo Plazo',                        // no se tiene registro de este dato
                ],
                [
                    'module_id' => 6,
                    'name' => 'Reprogramación del Refinanciamiento Préstamo a Largo Plazo',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'second_name' => 'Rep. Ref. Largo Plazo',                   // no se tiene registro de este dato
                ],
                [
                    'module_id' => 6,
                    'name' => 'Préstamo al Sector Activo con Garantía del Beneficio Fondo de Retiro Policial Solidario',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'second_name' => 'Fondo de Retiro',                         // no se tiene registro de este dato
                ],
                [
                    'module_id' => 6,
                    'name' => 'Préstamo Estacional para el Sector Pasivo de la Policía Boliviana',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'second_name' => 'Estacional',                              // no se tiene registro de este dato
                ],
            ]);
            //Creación y Actualización de Sub_Modalidades en la tabla procedure_modalities tomando en cuenta los ids de estos
            /* procedure_modalities id
            id = 9  --> Préstamo Anticipo
            id = 10 --> Préstamo a Corto Plazo
            id = 11 --> Refinanciamiento Préstamo a Corto Plazo
            id = 12 --> Préstamo a Largo Plazo
            id = 13 --> Refinanciamiento Préstamo a Largo Plazo
            id = 24 --> Reprogramación Préstamo a Corto Plazo                                                                //NUEVO
            id = 25 --> Reprogramación Refinanciamiento Préstamo a Corto Plazo                                               //NUEVO
            id = 26 --> Reprogramación Préstamo a Largo Plazo                                                                //NUEVO  
            id = 27 --> Reprogramación Refinanciamiento Préstamo a Largo Plazo                                               //NUEVO
            id = 28 --> Préstamo al Sector Activo con Garantía del Beneficio Fondo de Retiro Policial Solidario              //NUEVO
            id = 29 --> Préstamo Estacional para el Sector Pasivo de la Policía Boliviana                                    //NUEVO
        */

            //ACTUALIZACIÓN
            //Largo Plazo con Garantía Personal Sector Activo  -->  Largo Plazo con Garantía Personal Sector Activo con dos Garantes
            DB::table('procedure_modalities')->where('id', '43')->update([
                'name' => 'Largo Plazo con Garantía Personal Sector Activo con dos Garantes'
            ]);
            //Largo Plazo con un Solo Garante Sector Activo  -->  Con Pago Oportuno
            DB::table('procedure_modalities')->where('id', '46')->update([
                'name' => 'Largo Plazo con Pago Oportuno',
            ]);
            //Largo Plazo con Garantía Personal en Disponibilidad  -->  Largo Plazo con Garantía Personal en Disponibilidad con dos Garantes
            DB::table('procedure_modalities')->where('id', '65')->update([
                'name' => 'Largo Plazo con Garantía Personal en Disponibilidad con dos Garantes',
            ]);
            //Refinanciamiento Largo Plazo con Garantía Personal Sector Activo  -->  Refinanciamiento Largo Plazo con Garantía Personal Sector Activo con dos Garantes
            DB::table('procedure_modalities')->where('id', '47')->update([
                'name' => 'Refinanciamiento Largo Plazo con Garantía Personal Sector Activo con dos Garantes'
            ]);
            //Refinanciamiento Largo Plazo con un Solo Garante Sector Activo  -->  Refinanciamiento Con Pago Oportuno
            DB::table('procedure_modalities')->where('id', '50')->update([
                'name' => 'Refinanciamiento Largo Plazo con Pago Oportuno',
            ]);

            //CREACIÓN NUEVOS
            DB::table('procedure_modalities')->insert([
                //id = 24 --> REPROGRAMACIÓN PRESTAMO A CORTO PLAZO - SUB MODALIDADES
                [
                    'procedure_type_id' => 24,
                    'name' => 'Reprogramación Corto Plazo Sector Activo',
                    'shortened' => 'REP-COR-ACT',
                    'is_valid' => true,
                ],
                [
                    'procedure_type_id' => 24,
                    'name' => 'Reprogramación Corto Plazo en Disponibilidad',
                    'shortened' => 'REP-COR-DIS',
                    'is_valid' => true,
                ],
                [
                    'procedure_type_id' => 24,
                    'name' => 'Reprogramación Corto Plazo Sector Pasivo Gestora Pública',
                    'shortened' => 'REP-COR-GES',
                    'is_valid' => true,
                ],
                [
                    'procedure_type_id' => 24,
                    'name' => 'Reprogramación Corto Plazo Sector Pasivo SENASIR',
                    'shortened' => 'REP-COR-SEN',
                    'is_valid' => true,
                ],
                //id = 25 --> Reprogramación Refinanciamiento Préstamo a Corto Plazo                            //NUEVO
                [
                    'procedure_type_id' => 25,
                    'name' => 'Reprogramación del Refinanciamiento Corto Plazo Sector Activo',
                    'shortened' => 'REP-REF-COR-ACT',
                    'is_valid' => true,
                ],
                [
                    'procedure_type_id' => 25,
                    'name' => 'Reprogramación del Refinanciamiento Corto Plazo en Disponibilidad',
                    'shortened' => 'REP-REF-COR-DIS',
                    'is_valid' => true,
                ],
                [
                    'procedure_type_id' => 25,
                    'name' => 'Reprogramación del Refinanciamiento Corto Plazo Sector Pasivo Gestora Pública',
                    'shortened' => 'REP-REF-COR-GES',
                    'is_valid' => true,
                ],
                [
                    'procedure_type_id' => 25,
                    'name' => 'Reprogramación del Refinanciamiento Corto Plazo Sector Pasivo SENASIR',
                    'shortened' => 'REP-REF-COR-SEN',
                    'is_valid' => true,
                ],
                //id = 12 --> Préstamo a Largo Plazo
                [
                    'procedure_type_id' => 12,
                    'name' => 'Largo Plazo con Garantía Personal Sector Activo con un Garante',
                    'shortened' => 'LAR-ACT-1G',
                    'is_valid' => true,
                ],
                //id = 13 --> Refinanciamiento Préstamo a Largo Plazo
                [
                    'procedure_type_id' => 13,
                    'name' => 'Refinanciamiento Largo Plazo con Garantía Personal Sector Activo con un Garante',
                    'shortened' => 'REF-LAR-ACT-1G',
                    'is_valid' => true,
                ],
                //id = 26 --> Reprogramación Préstamo a Largo Plazo                                               //NUEVO
                [
                    'procedure_type_id' => 26,
                    'name' => 'Reprogramación Largo Plazo con Garantía Personal Sector Activo con un Garante',
                    'shortened' => 'REP-LAR-ACT-1G',
                    'is_valid' => true,
                ],
                [
                    'procedure_type_id' => 26,
                    'name' => 'Reprogramación Largo Plazo con Garantía Personal Sector Activo con dos Garantes',
                    'shortened' => 'REP-LAR-ACT-2G',
                    'is_valid' => true,
                ],
                [
                    'procedure_type_id' => 26,
                    'name' => 'Reprogramación Largo Plazo con Pago Oportuno',
                    'shortened' => 'REP-LAR-1G',
                    'is_valid' => true,
                ],
                [
                    'procedure_type_id' => 26,
                    'name' => 'Reprogramación Largo Plazo Sector Pasivo Gestora Pública',
                    'shortened' => 'REP-LAR-GES',
                    'is_valid' => true,
                ],
                [
                    'procedure_type_id' => 26,
                    'name' => 'Reprogramación Largo Plazo Sector Pasivo SENASIR',
                    'shortened' => 'REP-LAR-SEN',
                    'is_valid' => true,
                ],
                //id = 27 --> Reprogramación Refinanciamiento Préstamo a Largo Plazo                                               //NUEVO
                [
                    'procedure_type_id' => 27,
                    'name' => 'Reprogramación del Refinanciamiento Largo Plazo Sector Activo con un Garante',
                    'shortened' => 'REP-REF-LAR-ACT-1G',
                    'is_valid' => true,
                ],
                [
                    'procedure_type_id' => 27,
                    'name' => 'Reprogramación del Refinanciamiento Largo Plazo Sector Activo con dos Garantes',
                    'shortened' => 'REP-REF-LAR-ACT-2G',
                    'is_valid' => true,
                ],
                [
                    'procedure_type_id' => 27,
                    'name' => 'Reprogramación del Refinanciamiento Largo Plazo con Pago Oportuno',
                    'shortened' => 'REP-REF-LAR-1G',
                    'is_valid' => true,
                ],
                [
                    'procedure_type_id' => 27,
                    'name' => 'Reprogramación del Refinanciamiento Largo Plazo Sector Pasivo Gestora Pública',
                    'shortened' => 'REP-REF-LAR-GES',
                    'is_valid' => true,
                ],
                [
                    'procedure_type_id' => 27,
                    'name' => 'Reprogramación del Refinanciamiento Largo Plazo Sector Pasivo SENASIR',
                    'shortened' => 'REP-REF-LAR-SEN',
                    'is_valid' => true,
                ],
                //id = 28 --> Préstamo al Sector Activo con Garantía del Beneficio Fondo de Retiro Policial Solidario               //NUEVO
                [
                    'procedure_type_id' => 28,
                    'name' => 'Préstamo al Sector Activo con Garantía del Beneficio Fondo de Retiro Policial Solidario Menor',
                    'shortened' => 'FON-MEN',
                    'is_valid' => true,
                ],
                [
                    'procedure_type_id' => 28,
                    'name' => 'Préstamo al Sector Activo con Garantía del Beneficio Fondo de Retiro Policial Solidario Mayor',
                    'shortened' => 'FON-MAY',
                    'is_valid' => true,
                ],
                //id = 29 --> Préstamo Estacional para el Sector Pasivo de la Policía Boliviana                                     //NUEVO
                [
                    'procedure_type_id' => 29,
                    'name' => 'Préstamo Estacional para el Sector Pasivo de la Policía Boliviana con Cónyuge',
                    'shortened' => 'EST-PAS-CON',
                    'is_valid' => true,
                ],
                [
                    'procedure_type_id' => 29,
                    'name' => 'Préstamo Estacional para el Sector Pasivo de la Policía Boliviana',
                    'shortened' => 'EST-PAS',
                    'is_valid' => true,
                ],
                [
                    'procedure_type_id' => 12,
                    'name' => 'Largo Plazo con Garantía Personal en Disponibilidad con un Garante',
                    'shortened' => 'LAR-DIS-1G',
                    'is_valid' => true,
                ]
            ]);
            //ACTUALIZACIÓN
            //Largo Plazo con Garantía Personal Sector Activo con dos Garantes
            DB::table('loan_modality_parameters')->where('procedure_modality_id', '43')->update([
                'minimum_amount_modality' => 70001
            ]);
            //Largo Plazo con Pago Oportuno
            DB::table('loan_modality_parameters')->where('procedure_modality_id', '46')->update([
                'maximum_term_modality' => 72,
            ]);
            //Largo Plazo con Garantía Personal en Disponibilidad con dos Garantes
            DB::table('loan_modality_parameters')->where('procedure_modality_id', '65')->update([
                'minimum_amount_modality' => 70001
            ]);
            //Refinanciamiento Largo Plazo con Garantía Personal Sector Activo con dos Garantes
            DB::table('loan_modality_parameters')->where('procedure_modality_id', '47')->update([
                'minimum_amount_modality' => 70001
            ]);
            //Refinanciamiento Largo Plazo Con Pago Oportuno
            DB::table('loan_modality_parameters')->where('procedure_modality_id', '50')->update([
                'maximum_term_modality' => 72,
            ]);

            DB::table('loan_modality_parameters')->insert([
                //ANTICIPOS
                [
                    'procedure_modality_id' => 32,      //32	9	Anticipo Sector Activo
                    'debt_index' => 70,                 //Limite de endeudamiento de 50% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 0,
                    'max_lenders' => 1,
                    'min_guarantor_category' => null,
                    'max_guarantor_category' => null,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 7000,  //Monto Maximo del Préstamo
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 6,       //Máximo meses plazo de 3 a 6 meses
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => true,
                    'print_receipt_fund_rotary' => true,
                    'print_form_qualification_platform' => true,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => null,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 33,      //33	9	Anticipo en Disponibilidad
                    'debt_index' => 70,                 //Limite de endeudamiento de 50% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 0,
                    'max_lenders' => 1,
                    'min_guarantor_category' => null,
                    'max_guarantor_category' => null,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 7000,  //Monto Maximo del Préstamo SENASIR
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 6,       //Máximo meses plazo de 3 a 6 meses
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => true,
                    'print_receipt_fund_rotary' => true,
                    'print_form_qualification_platform' => true,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => null,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 67,      //67	9	Anticipo Sector Pasivo Gestora Pública
                    'debt_index' => 70,                 //Limite de endeudamiento de 50% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 7000,  //Monto Maximo del Préstamo
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 6,       //Maximo meses plazo de 3 a 6 meses
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => true,
                    'print_receipt_fund_rotary' => true,
                    'print_form_qualification_platform' => true,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,        //Limite de endeudamiento del garante de 50 a 25
                ],
                [
                    'procedure_modality_id' => 35,      //35	9	Anticipo Sector Pasivo SENASIR
                    'debt_index' => 70,                 //Limite de endeudamiento de 50% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 0,
                    'max_lenders' => 1,
                    'min_guarantor_category' => null,
                    'max_guarantor_category' => null,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 7000,  //Monto Maximo del Préstamo
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 6,       //Maximo meses plazo de 3 a 6 meses
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => true,
                    'print_receipt_fund_rotary' => true,
                    'print_form_qualification_platform' => true,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => null,
                    'loan_month_term' => 1,
                ],
                //CORTO PLAZO
                [
                    'procedure_modality_id' => 36,      //36	10	Corto Plazo Sector Activo
                    'debt_index' => 70,                 //Limite de endeudamiento de 50% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 0,
                    'max_lenders' => 1,
                    'min_guarantor_category' => null,
                    'max_guarantor_category' => null,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 25000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 24,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => true,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => null,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 37,      //37	10	Corto Plazo en Disponibilidad
                    'debt_index' => 70,                 //Limite de endeudamiento de 50% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 0,
                    'max_lenders' => 1,
                    'min_guarantor_category' => null,
                    'max_guarantor_category' => null,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 25000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 24,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => true,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => null,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 68,      //68	10	Corto Plazo Sector Pasivo Gestora Pública
                    'debt_index' => 70,                 //Limite de endeudamiento de 50% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 25000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 12,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => true,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => 50,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 39,      //39	10	Corto Plazo Sector Pasivo SENASIR
                    'debt_index' => 70,                 //Limite de endeudamiento de 50% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 0,
                    'max_lenders' => 1,
                    'min_guarantor_category' => null,
                    'max_guarantor_category' => null,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 25000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 12,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => true,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => null,
                    'loan_month_term' => 1,
                ],
                //REFINANCIAMIENTO CORTO PLAZO
                [
                    'procedure_modality_id' => 40,      //40	11	Refinanciamiento de Préstamo a Corto Plazo Sector Activo
                    'debt_index' => 70,                 //Limite de endeudamiento de 50% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 0,
                    'max_lenders' => 1,
                    'min_guarantor_category' => null,
                    'max_guarantor_category' => null,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 25000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 24,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => null,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 66,      //66	11	Refinanciamiento de Préstamo a Corto Plazo en Disponibilidad
                    'debt_index' => 70,                 //Limite de endeudamiento de 50% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 0,
                    'max_lenders' => 1,
                    'min_guarantor_category' => null,
                    'max_guarantor_category' => null,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 25000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 24,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => null,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 69,      //69	11	Refinanciamiento de Préstamo a Corto Plazo sector Pasivo Gestora Pública
                    'debt_index' => 70,                 //Limite de endeudamiento de 50% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 25000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 12,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => null,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 42,      //42	11	Refinanciamiento de Préstamo a Corto Plazo Sector Pasivo SENASIR
                    'debt_index' => 70,                 //Limite de endeudamiento de 50% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 0,
                    'max_lenders' => 1,
                    'min_guarantor_category' => null,
                    'max_guarantor_category' => null,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 25000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 12,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                //REPROGRAMACIÓN CORTO PLAZO
                [
                    'procedure_modality_id' => 73,      //73	24	Reprogramación Corto Plazo Sector Activo
                    'debt_index' => 70,                 //Limite de endeudamiento de 50% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 0,
                    'max_lenders' => 1,
                    'min_guarantor_category' => null,
                    'max_guarantor_category' => null,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 25000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => null,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 74,      //74	24	Reprogramación Corto Plazo en Disponibilidad
                    'debt_index' => 70,                 //Limite de endeudamiento de 50% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 0,
                    'max_lenders' => 1,
                    'min_guarantor_category' => null,
                    'max_guarantor_category' => null,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 25000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => null,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 75,      //75	24	Reprogramación Corto Plazo Sector Pasivo Gestora Pública
                    'debt_index' => 70,                 //Limite de endeudamiento de 50% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 25000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => null,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 76,      //76	24	Reprogramación Corto Plazo Sector Pasivo SENASIR
                    'debt_index' => 70,                 //Limite de endeudamiento de 50% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 0,
                    'max_lenders' => 1,
                    'min_guarantor_category' => null,
                    'max_guarantor_category' => null,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 25000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                //REPROGRAMACIÓN DEL REFINANCIAMIENTO CORTO PLAZO
                [
                    'procedure_modality_id' => 77,      //77	25	Reprogramación del Refinanciamiento Corto Plazo Sector Activo
                    'debt_index' => 70,                 //Limite de endeudamiento de 50% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 0,
                    'max_lenders' => 1,
                    'min_guarantor_category' => null,
                    'max_guarantor_category' => null,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 25000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 78,      //78	25	Reprogramación del Refinanciamiento Corto Plazo en Disponibilidad
                    'debt_index' => 70,                 //Limite de endeudamiento de 50% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 0,
                    'max_lenders' => 1,
                    'min_guarantor_category' => null,
                    'max_guarantor_category' => null,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 25000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => null,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 79,      //79	25	Reprogramación del Refinanciamiento Corto Plazo Sector Pasivo Gestora Pública
                    'debt_index' => 70,                 //Limite de endeudamiento de 50% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 25000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => null,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 80,      //80	25	Reprogramación del Refinanciamiento Corto Plazo Sector Pasivo SENASIR
                    'debt_index' => 70,                 //Limite de endeudamiento de 50% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 0,
                    'max_lenders' => 1,
                    'min_guarantor_category' => null,
                    'max_guarantor_category' => null,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 25000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                //LARGO PLAZO
                [
                    'procedure_modality_id' => 81,      //81	12	Largo Plazo con Garantía Personal Sector Activo con un Garante
                    'debt_index' => 70,                 //Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 70000, //Hasta 70000
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 43,      //43	12	Largo Plazo con Garantía Personal Sector Activo con dos Garantes
                    'debt_index' => 70,                 //Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 2,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 300000,
                    'minimum_amount_modality' => 70001,         //minimo hasta 70001
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 46,      //46	12	Con Pago Oportuno
                    'debt_index' => 70,                 //Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 300000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 72,      //72 Meses
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 70,      // 70	12	Largo Plazo con Garantía Personal Sector Pasivo Gestora Pública
                    'debt_index' => 70,                 //Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 300000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 24,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 45,      // 45	12	Largo Plazo con Garantía Personal Sector Pasivo SENASIR
                    'debt_index' => 70,                 //Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 300000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 24,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 65,      // 65	12	Largo Plazo con Garantía Personal en Disponibilidad con dos garantes
                    'debt_index' => 70,                 //Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 2,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 300000,
                    'minimum_amount_modality' => 70001,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                //REFINANCIAMIENTO LARGO PLAZO
                [
                    'procedure_modality_id' => 82,      // 82	13	Refinanciamiento Largo Plazo con Garantía Personal Sector Activo con un Garante
                    'debt_index' => 70,                 // Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 70000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 47,      // 47	13	Refinanciamiento Largo Plazo con Garantía Personal Sector Activo con dos Garantes
                    'debt_index' => 70,                 // Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 2,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 300000,
                    'minimum_amount_modality' => 70001,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 50,      // 50	13	Refinanciamiento Con Pago Oportuno
                    'debt_index' => 70,                 // Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 300000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 72,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 71,      // 71	13	Refinanciamiento de Préstamo a Largo Plazo Sector Pasivo Gestora Pública
                    'debt_index' => 70,                 // Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 300000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 24,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 49,      // 49	13	Refinanciamiento de Préstamo a Largo Plazo Sector Pasivo SENASIR
                    'debt_index' => 70,                 // Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 300000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 24,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                //REPROGRAMACIÓN LARGO PLAZO
                [
                    'procedure_modality_id' => 83,      // 83	26	Reprogramación Largo Plazo con Garantía Personal Sector Activo con un Garante
                    'debt_index' => 70,                 // Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 70000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 84,      // 84	26	Reprogramación Largo Plazo con Garantía Personal Sector Activo con dos Garantes
                    'debt_index' => 70,                 // Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 2,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 300000,
                    'minimum_amount_modality' => 70001,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 85,      //85	26	Reprogramación Con Pago Oportuno
                    'debt_index' => 70,                 // Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 300000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 72,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 86,      // 86	26	Reprogramación Largo Plazo Sector Pasivo Gestora Pública
                    'debt_index' => 70,                 // Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 300000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 87,      // 87	26	Reprogramación Largo Plazo Sector Pasivo SENASIR
                    'debt_index' => 70,                 // Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 300000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                //REPROGRAMACIÓN DEL REFINANCIAMIENTO LARGO PLAZO
                [
                    'procedure_modality_id' => 88,      // 88	27	Reprogramación del Refinanciamiento Largo Plazo Sector Activo con un Garante
                    'debt_index' => 70,                 // Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 70000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 89,      // 89	27	Reprogramación del Refinanciamiento Largo Plazo Sector Activo con dos Garantes
                    'debt_index' => 70,                 // Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 2,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 300000,
                    'minimum_amount_modality' => 70001,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 90,      // 90	27	Reprogramación del Refinanciamiento Con Pago Oportuno
                    'debt_index' => 70,                 // Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 300000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 72,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 91,      // 91	27	Reprogramación del Refinanciamiento Largo Plazo Sector Pasivo Gestora Pública
                    'debt_index' => 70,                 // Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 300000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 92,      // 92	27	Reprogramación del Refinanciamiento Largo Plazo Sector Pasivo SENASIR
                    'debt_index' => 70,                 // Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 300000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => 80000,
                    'guarantor_debt_index' => 25,
                    'loan_month_term' => 1,
                ],
                //POR BENEFICIO DEL FONDO DE RETIRO
                [
                    'procedure_modality_id' => 93,      // 93	28	Préstamo al Sector Activo con Garantía del Beneficio Fondo de Retiro Policial Solidario Menor
                    'debt_index' => 70,                 // Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 0,
                    'max_lenders' => 1,
                    'min_guarantor_category' => null,
                    'max_guarantor_category' => null,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 70000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => null,
                    'loan_month_term' => 1,
                ],
                [
                    'procedure_modality_id' => 94,      // 94	28	Préstamo al Sector Activo con Garantía del Beneficio Fondo de Retiro Policial Solidario Mayor
                    'debt_index' => 70,                 // Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 0,
                    'max_lenders' => 1,
                    'min_guarantor_category' => null,
                    'max_guarantor_category' => null,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 300000,
                    'minimum_amount_modality' => 70001,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => null,
                    'loan_month_term' => 1,
                ],
                //ESTACIONAL  
                [
                    'procedure_modality_id' => 95,      // 95	29	Préstamo Estacional para el Sector Pasivo de la Policía Boliviana con Cónyuge
                    'debt_index' => 70,                 // Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 0,
                    'max_lenders' => 1,
                    'min_guarantor_category' => null,
                    'max_guarantor_category' => null,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 300000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 4,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => null,
                    'loan_month_term' => 6,
                ],
                [
                    'procedure_modality_id' => 96,      // 96	29	Préstamo Estacional para el Sector Pasivo de la Policía Boliviana
                    'debt_index' => 70,                 // Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 0,
                    'max_lenders' => 1,
                    'min_guarantor_category' => null,
                    'max_guarantor_category' => null,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 300000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 2,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => null,
                    'loan_month_term' => 6,
                ],
                [
                    'procedure_modality_id' => 97,      // 97	12	Largo Plazo con Garantía Personal en Disponibilidad con un Garante
                    'debt_index' => 70,                 // Limite de endeudamiento de 40% al 70%
                    'quantity_ballots' => 1,
                    'guarantors' => 1,
                    'max_lenders' => 1,
                    'min_guarantor_category' => 0.35,
                    'max_guarantor_category' => 1,
                    'min_lender_category' => null,
                    'max_lender_category' => null,
                    'max_cosigner' => 0,
                    'personal_reference' => true,
                    'maximum_amount_modality' => 70000,
                    'minimum_amount_modality' => 1,
                    'maximum_term_modality' => 60,
                    'minimum_term_modality' => 1,
                    'print_contract_platform' => false,
                    'print_receipt_fund_rotary' => false,
                    'print_form_qualification_platform' => false,
                    'loan_procedure_id' => 3,
                    'max_approved_amount' => null,
                    'guarantor_debt_index' => null,
                    'loan_month_term' => 1,
                ],
            ]);
            //CREACION DE INTERES NUEVAS SUBMODALIDAD EN LA TABLA loan_interests
            //REPROGRAMACIÓN CORTO PLAZO
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 73,       //73	24	Reprogramación Corto Plazo Sector Activo
                    'annual_interest' => 20,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 74,       //74	24	Reprogramación Corto Plazo en Disponibilidad
                    'annual_interest' => 20,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 75,       //75	24	Reprogramación Corto Plazo Sector Pasivo Gestora Pública
                    'annual_interest' => 20,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 76,       //76	24	Reprogramación Corto Plazo Sector Pasivo SENASIR
                    'annual_interest' => 20,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //REPROGRAMACIÓN DEL REFINANCIAMIENTO CORTO PLAZO
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 77,       //77	25	Reprogramación del Refinanciamiento Corto Plazo Sector Activo
                    'annual_interest' => 20,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 78,       //78	25	Reprogramación del Refinanciamiento Corto Plazo en Disponibilidad
                    'annual_interest' => 20,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 79,       //79	25	Reprogramación del Refinanciamiento Corto Plazo Sector Pasivo Gestora Pública
                    'annual_interest' => 20,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 80,       //80	25	Reprogramación del Refinanciamiento Corto Plazo Sector Pasivo SENASIR
                    'annual_interest' => 20,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //LARGO PLAZO
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 81,       //81	12	Largo Plazo con Garantía Personal Sector Activo con un Garante
                    'annual_interest' => 13.2,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //REFINANCIAMIENTO LARGO PLAZO
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 82,       //82	13	Refinanciamiento Largo Plazo con Garantía Personal Sector Activo con un Garante
                    'annual_interest' => 13.2,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //REPROGRAMACIÓN LARGO PLAZO
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 83,       //83	26	Reprogramación Largo Plazo con Garantía Personal Sector Activo con un Garante
                    'annual_interest' => 13.2,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 84,       //84	26	Reprogramación Largo Plazo con Garantía Personal Sector Activo con dos Garantes
                    'annual_interest' => 13.2,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 85,       //85	26	Reprogramación Con Pago Oportuno
                    'annual_interest' => 13.2,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 86,       //86	26	Reprogramación Largo Plazo Sector Pasivo Gestora Pública
                    'annual_interest' => 13.2,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 87,       //87	26	Reprogramación Largo Plazo Sector Pasivo SENASIR
                    'annual_interest' => 13.2,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //REPROGRAMACIÓN DEL REFINANCIAMIENTO LARGO PLAZO
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 88,       //88  	27	Reprogramación del Refinanciamiento Largo Plazo Sector Activo con un Garante
                    'annual_interest' => 13.2,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 89,       //89	27	Reprogramación del Refinanciamiento Largo Plazo Sector Activo con dos Garantes
                    'annual_interest' => 13.2,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 90,       //90	27	Reprogramación del Refinanciamiento Con Pago Oportuno
                    'annual_interest' => 13.2,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 91,       //91	27	Reprogramación del Refinanciamiento Largo Plazo Sector Pasivo Gestora Pública
                    'annual_interest' => 13.2,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 92,       //92	27	Reprogramación del Refinanciamiento Largo Plazo Sector Pasivo SENASIR
                    'annual_interest' => 13.2,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //POR BENEFICIO DEL FONDO DE RETIRO
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 93,       //93	28	Préstamo al Sector Activo con Garantía del Beneficio Fondo de Retiro Policial Solidario Menor
                    'annual_interest' => 20,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 94,       //94	28	Préstamo al Sector Activo con Garantía del Beneficio Fondo de Retiro Policial Solidario Mayor
                    'annual_interest' => 13.2,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //ESTACIONAL    
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 95,       //95	29	Préstamo Estacional para el Sector Pasivo de la Policía Boliviana con Cónyuge
                    'annual_interest' => 15,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 96,       //96	29	Préstamo Estacional para el Sector Pasivo de la Policía Boliviana
                    'annual_interest' => 15,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('loan_interests')->insert([
                [
                    'procedure_modality_id' => 97,       //97	12	Largo Plazo con Garantía Personal en Disponibilidad con un Garante
                    'annual_interest' => 13.2,
                    'penal_interest' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::commit();
        } catch (\Exception $e) {
            // Revertir todas las operaciones en caso de error
            DB::rollBack();
        }
    }
}
//php artisan db:seed --class=UpdateNewReglament2024Part1