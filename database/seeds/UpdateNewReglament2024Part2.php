<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\ProcedureRequirement;

class UpdateNewReglament2024Part2 extends Seeder
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
            DB::statement('SELECT setval(\'procedure_requirements_id_seq\', (SELECT COALESCE(MAX(id), 0) FROM procedure_requirements))');
            DB::statement('SELECT setval(\'procedure_documents_id_seq\', (SELECT COALESCE(MAX(id), 0) FROM procedure_documents))');

            //ASIGNACIÓN DE DESTINOS DE LAS NUEVAS MODALIDADES
            //Reprogramación Corto Plazo
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 24,
                    'loan_destiny_id' => 3,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 24,
                    'loan_destiny_id' => 2,
                ]
            ]);
            //Reprogramación del Refinanciamiento Corto Plazo
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 25,
                    'loan_destiny_id' => 3,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 25,
                    'loan_destiny_id' => 2,
                ]
            ]);
            //Reprogramación Largo PLazo
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 26,
                    'loan_destiny_id' => 2,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 26,
                    'loan_destiny_id' => 4,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 26,
                    'loan_destiny_id' => 5,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 26,
                    'loan_destiny_id' => 6,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 26,
                    'loan_destiny_id' => 7,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 26,
                    'loan_destiny_id' => 8,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 26,
                    'loan_destiny_id' => 9,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 26,
                    'loan_destiny_id' => 10,
                ]
            ]);
            //Reprogramación Largo PLazo
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 26,
                    'loan_destiny_id' => 2,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 26,
                    'loan_destiny_id' => 4,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 26,
                    'loan_destiny_id' => 5,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 26,
                    'loan_destiny_id' => 6,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 26,
                    'loan_destiny_id' => 7,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 26,
                    'loan_destiny_id' => 8,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 26,
                    'loan_destiny_id' => 9,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 26,
                    'loan_destiny_id' => 10,
                ]
            ]);
            //Reprogramación del Refinanciamiento Largo PLazo
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 27,
                    'loan_destiny_id' => 2,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 27,
                    'loan_destiny_id' => 4,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 27,
                    'loan_destiny_id' => 5,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 27,
                    'loan_destiny_id' => 6,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 27,
                    'loan_destiny_id' => 7,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 27,
                    'loan_destiny_id' => 8,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 27,
                    'loan_destiny_id' => 9,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 27,
                    'loan_destiny_id' => 10,
                ]
            ]);
            //Por Beneficio del Fondo de Retiro
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 28,
                    'loan_destiny_id' => 1,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 28,
                    'loan_destiny_id' => 2,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 28,
                    'loan_destiny_id' => 3,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 28,
                    'loan_destiny_id' => 7,
                ]
            ]);
            //ESTACIONALES
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 29,
                    'loan_destiny_id' => 1,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 29,
                    'loan_destiny_id' => 2,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 29,
                    'loan_destiny_id' => 3,
                ]
            ]);
            DB::table('loan_destiny_procedure_type')->insert([
                [
                    'procedure_type_id' => 29,
                    'loan_destiny_id' => 7,
                ]
            ]);
            //ACTUALIZACIÓN DE QUITAR REQUERIMIENTOS A TODAS LAS SUB MODALIDADES
            //Conformidad de devolución de descuento por garantía original.
            ProcedureRequirement::where('procedure_document_id', 278)->delete();
            //Conformidad de devolución de descuento por garantía copia legalizada.
            ProcedureRequirement::where('procedure_document_id', 279)->delete();
            //Certificado de aportes para el Auxilio Mortuorio de los 3 últimos meses.
            ProcedureRequirement::where('procedure_document_id', 284)->delete();
            //Memorándum de asignación a la letra en copia simple.
            ProcedureRequirement::where('procedure_document_id', 280)->delete();
            //ACTUALIZACION DE NOMBRE DE DOCUMENTOS "en copia simple" al final.
            DB::table('procedure_documents')->where('id', '297')->update([
                'name' => 'Cédula de identidad del Solicitante en copia simple.',
            ]);
            DB::table('procedure_documents')->where('id', '300')->update([
                'name' => 'Cédula de Identidad del Garante uno en copia simple.',
            ]);
            DB::table('procedure_documents')->where('id', '301')->update([
                'name' => 'Última boleta de pago del Garante uno en copia simple.',
            ]);
            DB::table('procedure_documents')->where('id', '303')->update([
                'name' => 'Cédula de Identidad del Garante dos en copia simple.',
            ]);
            DB::table('procedure_documents')->where('id', '304')->update([
                'name' => 'Última boleta de pago del Garante dos en copia simple.',
            ]);
            DB::table('procedure_documents')->where('id', '308')->update([
                'name' => 'Cédula de Identidad del Garante en copia simple.',
            ]);
            DB::table('procedure_documents')->where('id', '309')->update([
                'name' => 'Última boleta de pago del Garante en copia simple.',
            ]);
            DB::table('procedure_documents')->where('id', '369')->update([
                'name' => 'Certificado de haberes del Garante en copia simple.',
            ]);
            DB::table('procedure_documents')->where('id', '371')->update([
                'name' => 'Certificado de haberes Garante uno en copia simple.',
            ]);
            DB::table('procedure_documents')->where('id', '372')->update([
                'name' => 'Certificado de haberes Garante dos en copia simple.',
            ]);
            //CREACIÓN DE NUEVOS DOCUMENTOS
            DB::table('procedure_documents')->insert([
                [
                    'name' => 'Cédula de identidad del cónyuge en copia simple.',
                    'created_at' => now(),

                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_documents')->insert([
                [
                    'name' => 'Certificado de Matrimonio.',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_documents')->insert([
                [
                    'name' => 'Detalle de pago del complemento Económico (último semestre).',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_documents')->insert([
                [
                    'name' => 'Certificado de Renta de jubilación del Garante en copia simple.',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_documents')->insert([
                [
                    'name' => 'Solicitud de aclaración de datos personales en la Boleta de Pago del garante uno.',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_documents')->insert([
                [
                    'name' => 'Solicitud de aclaración de datos personales en la Boleta de Pago del garante dos.',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_documents')->insert([
                [
                    'name' => 'Certificado de no adeudo, emitido por la instancia correspondiente del garante uno.',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_documents')->insert([
                [
                    'name' => 'Certificado de no adeudo, emitido por la instancia correspondiente del garante dos.',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //ACTUALIZACIÓN DE REQUERIMIENTOS SEGÚN NUEVO REGLAMENTO DE TODAS LAS MODALIDADES
            //Anticipo en Disponibilidad
            DB::table('procedure_requirements')->where('id', '1794')->update([
                'number' => 3,
            ]);
            DB::table('procedure_requirements')->where('id', '1795')->update([
                'number' => 4,
            ]);
            DB::table('procedure_requirements')->where('id', '2137')->update([
                'number' => 5,
            ]);
            //Anticipo Sector Pasivo Gestora Pública
            DB::table('procedure_requirements')->where('id', '1991')->update([
                'number' => 3,
            ]);
            DB::table('procedure_requirements')->where('id', '1996')->update([
                'number' => 4,
            ]);
            DB::table('procedure_requirements')->where('id', '1992')->update([
                'number' => 4,
            ]);
            DB::table('procedure_requirements')->where('id', '1994')->update([
                'number' => 5,
            ]);
            DB::table('procedure_requirements')->where('id', '1995')->update([
                'number' => 6,
            ]);
            DB::table('procedure_requirements')->where('id', '2141')->update([
                'number' => 7,
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 67,
                    'procedure_document_id' => 425,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //Corto Plazo Sector Activo
            ProcedureRequirement::where('id', 1362)->delete();
            ProcedureRequirement::where('id', 1361)->delete();
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 36,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            ProcedureRequirement::where('id', 1352)->delete();
            ProcedureRequirement::where('id', 1354)->delete();
            ProcedureRequirement::where('id', 1353)->delete();
            ProcedureRequirement::where('id', 1356)->delete();
            ProcedureRequirement::where('id', 1355)->delete();
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 36,
                    'procedure_document_id' => 418,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //Corto Plazo en Disponibilidad
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 37,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            ProcedureRequirement::where('id', 1365)->delete();
            ProcedureRequirement::where('id', 1366)->delete();
            ProcedureRequirement::where('id', 1364)->delete();
            ProcedureRequirement::where('id', 1367)->delete();
            ProcedureRequirement::where('id', 1368)->delete();
            ProcedureRequirement::where('id', 1369)->delete();
            ProcedureRequirement::where('id', 1370)->delete();
            DB::table('procedure_requirements')->where('id', '1809')->update([
                'number' => 4,
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 37,
                    'procedure_document_id' => 418,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //Corto Plazo Sector Pasivo Gestora Pública
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 68,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 68,
                    'procedure_document_id' => 421,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 68,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            ProcedureRequirement::where('id', 2007)->delete();
            DB::table('procedure_requirements')->where('id', '2008')->update([
                'number' => 6,
            ]);
            ProcedureRequirement::where('id', 2007)->delete();
            ProcedureRequirement::where('id', 1998)->delete();
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 68,
                    'procedure_document_id' => 420,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 68,
                    'procedure_document_id' => 425,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 68,
                    'procedure_document_id' => 418,
                    'number' => 7,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //Corto Plazo Sector Pasivo SENASIR
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 39,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            ProcedureRequirement::where('id', 1389)->delete();
            ProcedureRequirement::where('id', 1391)->delete();
            ProcedureRequirement::where('id', 1392)->delete();
            ProcedureRequirement::where('id', 1393)->delete();
            ProcedureRequirement::where('id', 1394)->delete();
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 39,
                    'procedure_document_id' => 418,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //Refinanciamiento de Préstamo a Corto Plazo Sector Activo
            ProcedureRequirement::where('id', 1409)->delete();
            ProcedureRequirement::where('id', 1408)->delete();
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 40,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            ProcedureRequirement::where('id', 1399)->delete();
            ProcedureRequirement::where('id', 1401)->delete();
            ProcedureRequirement::where('id', 1400)->delete();
            ProcedureRequirement::where('id', 1403)->delete();
            ProcedureRequirement::where('id', 1402)->delete();
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 40,
                    'procedure_document_id' => 418,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //Refinanciamiento de Préstamo a Corto Plazo en Disponibilidad
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 66,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->where('id', '1905')->update([
                'number' => 4,
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 66,
                    'procedure_document_id' => 418,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //Refinanciamiento de Préstamo a Corto Plazo sector Pasivo Gestora Pública
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 69,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 69,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 69,
                    'procedure_document_id' => 421,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            ProcedureRequirement::where('id', 2016)->delete();
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 69,
                    'procedure_document_id' => 420,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->where('id', '2020')->update([
                'number' => 6,
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 69,
                    'procedure_document_id' => 425,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 69,
                    'procedure_document_id' => 418,
                    'number' => 7,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //Refinanciamiento de Préstamo a Corto Plazo Sector Pasivo SENASIR
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 42,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            ProcedureRequirement::where('id', 1425)->delete();
            ProcedureRequirement::where('id', 1424)->delete();
            ProcedureRequirement::where('id', 1426)->delete();
            ProcedureRequirement::where('id', 1427)->delete();
            ProcedureRequirement::where('id', 1428)->delete();
            ProcedureRequirement::where('id', 1429)->delete();
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 42,
                    'procedure_document_id' => 418,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //CREACIÓN DE REQUERIMIENTOS DE LAS NUEVAS SUB MODALIDADES 
            //73	24	Reprogramación Corto Plazo Sector Activo
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 73,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 73,
                    'procedure_document_id' => 277,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 73,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 73,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 73,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 73,
                    'procedure_document_id' => 366,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 73,
                    'procedure_document_id' => 367,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 73,
                    'procedure_document_id' => 418,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //74	24	Reprogramación Corto Plazo en Disponibilidad
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 74,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 74,
                    'procedure_document_id' => 277,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 74,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 74,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 74,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 74,
                    'procedure_document_id' => 366,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 74,
                    'procedure_document_id' => 367,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 74,
                    'procedure_document_id' => 418,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //75	24	Reprogramación Corto Plazo Sector Pasivo Gestora Pública
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 75,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 75,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 75,
                    'procedure_document_id' => 421,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 75,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 75,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 75,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 75,
                    'procedure_document_id' => 420,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 75,
                    'procedure_document_id' => 295,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 75,
                    'procedure_document_id' => 296,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 75,
                    'procedure_document_id' => 368,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 75,
                    'procedure_document_id' => 368,
                    'number' => 425,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 75,
                    'procedure_document_id' => 367,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 75,
                    'procedure_document_id' => 418,
                    'number' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //76	24	Reprogramación Corto Plazo Sector Pasivo SENASIR
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 76,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 76,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 76,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 76,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 76,
                    'procedure_document_id' => 369,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 76,
                    'procedure_document_id' => 367,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 76,
                    'procedure_document_id' => 418,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //REPROGRAMACIÓN DEL REFINANCIAMIENTO CORTO PLAZO  
            //77	24	Reprogramación del Refinanciamiento Corto Plazo Sector Activo
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 77,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 77,
                    'procedure_document_id' => 277,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 77,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 77,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 77,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 77,
                    'procedure_document_id' => 366,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 77,
                    'procedure_document_id' => 367,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 77,
                    'procedure_document_id' => 418,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //78	24	Reprogramación del Refinanciamiento Corto Plazo en Disponibilidad
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 78,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 78,
                    'procedure_document_id' => 277,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 78,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 78,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 78,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 78,
                    'procedure_document_id' => 366,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 78,
                    'procedure_document_id' => 367,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 78,
                    'procedure_document_id' => 418,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //79	24	Reprogramación del Refinanciamiento Corto Plazo Sector Pasivo Gestora Pública
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 79,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 79,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 79,
                    'procedure_document_id' => 421,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 79,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 79,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 79,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 79,
                    'procedure_document_id' => 420,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 79,
                    'procedure_document_id' => 295,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 79,
                    'procedure_document_id' => 296,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 79,
                    'procedure_document_id' => 368,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 79,
                    'procedure_document_id' => 425,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 79,
                    'procedure_document_id' => 367,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 79,
                    'procedure_document_id' => 418,
                    'number' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //80	24	Reprogramación del Refinanciamiento Corto Plazo Sector Pasivo SENASIR
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 80,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 80,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 80,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 80,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 80,
                    'procedure_document_id' => 369,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 80,
                    'procedure_document_id' => 367,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 80,
                    'procedure_document_id' => 418,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //LARGO PLAZO
            //81	12	Largo Plazo con Garantía Personal Sector Activo con un Garante
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 81,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 81,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 81,
                    'procedure_document_id' => 277,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 81,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 81,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 81,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 81,
                    'procedure_document_id' => 366,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 81,
                    'procedure_document_id' => 295,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 81,
                    'procedure_document_id' => 296,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 81,
                    'procedure_document_id' => 368,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 81,
                    'procedure_document_id' => 272,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 81,
                    'procedure_document_id' => 367,
                    'number' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 81,
                    'procedure_document_id' => 418,
                    'number' => 7,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //Largo Plazo con Garantía Personal Sector Activo con dos Garantes
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 43,
                    'procedure_document_id' => 426,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 43,
                    'procedure_document_id' => 427,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 43,
                    'procedure_document_id' => 428,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 43,
                    'procedure_document_id' => 429,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            ProcedureRequirement::where('id', 1449)->delete();
            ProcedureRequirement::where('id', 1448)->delete();
            ProcedureRequirement::where('id', 1450)->delete();
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 43,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            ProcedureRequirement::where('id', 1435)->delete();
            ProcedureRequirement::where('id', 1438)->delete();
            ProcedureRequirement::where('id', 1441)->delete();
            ProcedureRequirement::where('id', 1442)->delete();
            ProcedureRequirement::where('id', 1443)->delete();
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 43,
                    'procedure_document_id' => 418,
                    'number' => 9,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //Largo Plazo con Pago Oportuno
            ProcedureRequirement::where('id', 1490)->delete();
            ProcedureRequirement::where('id', 1489)->delete();
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 46,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 46,
                    'procedure_document_id' => 421,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            ProcedureRequirement::where('id', 1488)->delete();
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 46,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            ProcedureRequirement::where('id', 1478)->delete();
            ProcedureRequirement::where('id', 1481)->delete();
            ProcedureRequirement::where('id', 1483)->delete();
            ProcedureRequirement::where('id', 1482)->delete();
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 46,
                    'procedure_document_id' => 418,
                    'number' => 7,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //Largo Plazo con Garantía Personal Sector Pasivo Gestora Pública
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 70,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 70,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 70,
                    'procedure_document_id' => 421,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            ProcedureRequirement::where('id', 2028)->delete();
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 70,
                    'procedure_document_id' => 420,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->where('id', '2031')->update([
                'number' => 5,
            ]);
            DB::table('procedure_requirements')->where('id', '2032')->update([
                'number' => 6,
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 70,
                    'procedure_document_id' => 425,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 70,
                    'procedure_document_id' => 418,
                    'number' => 7,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //Largo Plazo con Garantía Personal Sector Pasivo SENASIR
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 45,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 45,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 45,
                    'procedure_document_id' => 421,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            ProcedureRequirement::where('id', 1466)->delete();
            ProcedureRequirement::where('id', 1469)->delete();
            ProcedureRequirement::where('id', 1470)->delete();
            ProcedureRequirement::where('id', 1472)->delete();
            ProcedureRequirement::where('id', 1471)->delete();
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 45,
                    'procedure_document_id' => 425,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 45,
                    'procedure_document_id' => 418,
                    'number' => 7,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //97 12 Largo Plazo con Garantía Personal en Disponibilidad con un Garante
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 97,
                    'procedure_document_id' => 277,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 97,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 97,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 97,
                    'procedure_document_id' => 421,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 97,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 97,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 97,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 97,
                    'procedure_document_id' => 366,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 97,
                    'procedure_document_id' => 295,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 97,
                    'procedure_document_id' => 296,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 97,
                    'procedure_document_id' => 368,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 97,
                    'procedure_document_id' => 272,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 97,
                    'procedure_document_id' => 367,
                    'number' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 97,
                    'procedure_document_id' => 418,
                    'number' => 7,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //Largo Plazo con Garantía Personal en Disponibilidad con dos Garantes
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 65,
                    'procedure_document_id' => 426,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 65,
                    'procedure_document_id' => 427,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 65,
                    'procedure_document_id' => 428,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 65,
                    'procedure_document_id' => 429,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 65,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 65,
                    'procedure_document_id' => 418,
                    'number' => 10,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->where('id', '1865')->update([
                'number' => 7,
            ]);
            DB::table('procedure_requirements')->where('id', '1866')->update([
                'number' => 8,
            ]);
            DB::table('procedure_requirements')->where('id', '2289')->update([
                'number' => 9,
            ]);
            //REFINANCIAMIENTO LARGO PLAZO
            //82	13	Refinanciamiento Largo Plazo con Garantía Personal Sector Activo con un Garante
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 82,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 82,
                    'procedure_document_id' => 421,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 82,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 82,
                    'procedure_document_id' => 277,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 82,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 82,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 82,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 82,
                    'procedure_document_id' => 366,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 82,
                    'procedure_document_id' => 295,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 82,
                    'procedure_document_id' => 296,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 82,
                    'procedure_document_id' => 368,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 82,
                    'procedure_document_id' => 272,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 82,
                    'procedure_document_id' => 367,
                    'number' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 82,
                    'procedure_document_id' => 418,
                    'number' => 7,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //Refinanciamiento Largo Plazo con Garantía Personal Sector Activo con dos Garantes
            ProcedureRequirement::where('id', 1507)->delete();
            ProcedureRequirement::where('id', 1506)->delete();
            ProcedureRequirement::where('id', 1508)->delete();
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 47,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 47,
                    'procedure_document_id' => 426,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 47,
                    'procedure_document_id' => 427,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 47,
                    'procedure_document_id' => 428,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 47,
                    'procedure_document_id' => 429,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            ProcedureRequirement::where('id', 1493)->delete();
            ProcedureRequirement::where('id', 1496)->delete();
            ProcedureRequirement::where('id', 1499)->delete();
            ProcedureRequirement::where('id', 1500)->delete();
            ProcedureRequirement::where('id', 1501)->delete();
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 47,
                    'procedure_document_id' => 418,
                    'number' => 9,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //Refinanciamiento Largo Plazo con Pago Oportuno
            ProcedureRequirement::where('id', 1546)->delete();
            ProcedureRequirement::where('id', 1548)->delete();
            ProcedureRequirement::where('id', 1547)->delete();
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 50,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 50,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 50,
                    'procedure_document_id' => 421,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            ProcedureRequirement::where('id', 1536)->delete();
            ProcedureRequirement::where('id', 1539)->delete();
            ProcedureRequirement::where('id', 1541)->delete();
            ProcedureRequirement::where('id', 1540)->delete();
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 50,
                    'procedure_document_id' => 418,
                    'number' => 9,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //Refinanciamiento de Préstamo a Largo Plazo Sector Pasivo Gestora Pública
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 71,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 71,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 71,
                    'procedure_document_id' => 421,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->where('id', '2043')->update([
                'number' => 5,
            ]);
            DB::table('procedure_requirements')->where('id', '2044')->update([
                'number' => 6,
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 71,
                    'procedure_document_id' => 418,
                    'number' => 7,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            ProcedureRequirement::where('id', 2040)->delete();
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 71,
                    'procedure_document_id' => 420,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 71,
                    'procedure_document_id' => 425,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //Refinanciamiento de Préstamo a Largo Plazo Sector Pasivo SENASIR
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 49,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 49,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 49,
                    'procedure_document_id' => 421,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            ProcedureRequirement::where('id', 1524)->delete();
            ProcedureRequirement::where('id', 1527)->delete();
            ProcedureRequirement::where('id', 1528)->delete();
            ProcedureRequirement::where('id', 1530)->delete();
            ProcedureRequirement::where('id', 1529)->delete();
            DB::table('procedure_requirements')->where('id', '1891')->update([
                'number' => 6,
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 49,
                    'procedure_document_id' => 418,
                    'number' => 7,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 49,
                    'procedure_document_id' => 425,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //REPROGRAMACIÓN LARGO PLAZO
            //83	26	Reprogramación Largo Plazo con Garantía Personal Sector Activo con un Garante
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 83,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 83,
                    'procedure_document_id' => 277,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 83,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 83,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 83,
                    'procedure_document_id' => 421,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 83,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 83,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 83,
                    'procedure_document_id' => 366,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 83,
                    'procedure_document_id' => 295,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 83,
                    'procedure_document_id' => 296,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 83,
                    'procedure_document_id' => 368,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 83,
                    'procedure_document_id' => 367,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 83,
                    'procedure_document_id' => 418,
                    'number' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //84	26	Reprogramación Largo Plazo con Garantía Personal Sector Activo con dos Garantes
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 84,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 84,
                    'procedure_document_id' => 277,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 84,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 84,
                    'procedure_document_id' => 426,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 84,
                    'procedure_document_id' => 427,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 84,
                    'procedure_document_id' => 428,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 84,
                    'procedure_document_id' => 428,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 84,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 84,
                    'procedure_document_id' => 298,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 84,
                    'procedure_document_id' => 370,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 84,
                    'procedure_document_id' => 300,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 84,
                    'procedure_document_id' => 301,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 84,
                    'procedure_document_id' => 371,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 84,
                    'procedure_document_id' => 303,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 84,
                    'procedure_document_id' => 304,
                    'number' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 84,
                    'procedure_document_id' => 372,
                    'number' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 84,
                    'procedure_document_id' => 367,
                    'number' => 7,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 84,
                    'procedure_document_id' => 418,
                    'number' => 8,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //85	26	Reprogramación Con Pago Oportuno
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 85,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 85,
                    'procedure_document_id' => 277,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 85,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 85,
                    'procedure_document_id' => 421,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 85,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 85,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 85,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 85,
                    'procedure_document_id' => 366,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 85,
                    'procedure_document_id' => 295,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 85,
                    'procedure_document_id' => 296,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 85,
                    'procedure_document_id' => 368,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 85,
                    'procedure_document_id' => 367,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 85,
                    'procedure_document_id' => 418,
                    'number' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //86	26	Reprogramación Largo Plazo Sector Pasivo Gestora Pública
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 86,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 86,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 86,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 86,
                    'procedure_document_id' => 421,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 86,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 86,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 86,
                    'procedure_document_id' => 420,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 86,
                    'procedure_document_id' => 295,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 86,
                    'procedure_document_id' => 296,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 86,
                    'procedure_document_id' => 368,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 86,
                    'procedure_document_id' => 425,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 86,
                    'procedure_document_id' => 367,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 86,
                    'procedure_document_id' => 418,
                    'number' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //87	26	Reprogramación Largo Plazo Sector Pasivo SENASIR
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 87,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 87,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 87,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 87,
                    'procedure_document_id' => 421,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 87,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 87,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 87,
                    'procedure_document_id' => 369,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 87,
                    'procedure_document_id' => 295,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 87,
                    'procedure_document_id' => 296,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 87,
                    'procedure_document_id' => 368,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 87,
                    'procedure_document_id' => 425,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 87,
                    'procedure_document_id' => 367,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 87,
                    'procedure_document_id' => 418,
                    'number' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //REPROGRAMACIÓN DEL REFINANCIAMIENTO LARGO PLAZO
            //88	26	Reprogramación del Refinanciamiento Largo Plazo con Garantía Personal Sector Activo con un Garante
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 88,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 88,
                    'procedure_document_id' => 277,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 88,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 88,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 88,
                    'procedure_document_id' => 421,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 88,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 88,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 88,
                    'procedure_document_id' => 366,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 88,
                    'procedure_document_id' => 295,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 88,
                    'procedure_document_id' => 296,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 88,
                    'procedure_document_id' => 368,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 88,
                    'procedure_document_id' => 367,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 88,
                    'procedure_document_id' => 418,
                    'number' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //89	26	Reprogramación del Refinanciamiento Largo Plazo con Garantía Personal Sector Activo con dos Garantes
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 89,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 89,
                    'procedure_document_id' => 277,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 89,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 89,
                    'procedure_document_id' => 426,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 89,
                    'procedure_document_id' => 427,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 89,
                    'procedure_document_id' => 428,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 89,
                    'procedure_document_id' => 429,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 89,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 89,
                    'procedure_document_id' => 298,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 89,
                    'procedure_document_id' => 370,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 89,
                    'procedure_document_id' => 300,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 89,
                    'procedure_document_id' => 301,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 89,
                    'procedure_document_id' => 371,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 89,
                    'procedure_document_id' => 303,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 89,
                    'procedure_document_id' => 304,
                    'number' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 89,
                    'procedure_document_id' => 372,
                    'number' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 89,
                    'procedure_document_id' => 367,
                    'number' => 7,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 89,
                    'procedure_document_id' => 418,
                    'number' => 8,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //90	26	Reprogramación del Refinanciamiento Con Pago Oportuno
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 90,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 90,
                    'procedure_document_id' => 277,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 90,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 90,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 90,
                    'procedure_document_id' => 421,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 90,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 90,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 90,
                    'procedure_document_id' => 366,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 90,
                    'procedure_document_id' => 295,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 90,
                    'procedure_document_id' => 296,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 90,
                    'procedure_document_id' => 368,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 90,
                    'procedure_document_id' => 367,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 90,
                    'procedure_document_id' => 418,
                    'number' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //91	26	Reprogramación del Refinanciamiento Largo Plazo Sector Pasivo Gestora Pública
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 91,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 91,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 91,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 91,
                    'procedure_document_id' => 421,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 91,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 91,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 91,
                    'procedure_document_id' => 420,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 91,
                    'procedure_document_id' => 295,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 91,
                    'procedure_document_id' => 296,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 91,
                    'procedure_document_id' => 368,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 91,
                    'procedure_document_id' => 425,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 91,
                    'procedure_document_id' => 367,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 91,
                    'procedure_document_id' => 418,
                    'number' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //92	26	Reprogramación del Refinanciamiento Largo Plazo Sector Pasivo SENASIR
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 92,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 92,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 92,
                    'procedure_document_id' => 419,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 92,
                    'procedure_document_id' => 421,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 92,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 92,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 92,
                    'procedure_document_id' => 369,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 92,
                    'procedure_document_id' => 295,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 92,
                    'procedure_document_id' => 296,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 92,
                    'procedure_document_id' => 368,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 92,
                    'procedure_document_id' => 425,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 92,
                    'procedure_document_id' => 367,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 92,
                    'procedure_document_id' => 418,
                    'number' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //POR BENEFICIO DEL FONDO DE RETIRO
            //93	28	Préstamo al Sector Activo con Garantía del Beneficio Fondo de Retiro Policial Solidario Menor
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 93,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 93,
                    'procedure_document_id' => 277,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 93,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 93,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 93,
                    'procedure_document_id' => 366,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 93,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 93,
                    'procedure_document_id' => 272,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 93,
                    'procedure_document_id' => 367,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 93,
                    'procedure_document_id' => 418,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //94	28	Préstamo al Sector Activo con Garantía del Beneficio Fondo de Retiro Policial Solidario Mayor
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 94,
                    'procedure_document_id' => 276,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 94,
                    'procedure_document_id' => 277,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 94,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 94,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 94,
                    'procedure_document_id' => 366,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 94,
                    'procedure_document_id' => 274,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 94,
                    'procedure_document_id' => 272,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 94,
                    'procedure_document_id' => 367,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 94,
                    'procedure_document_id' => 418,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //ESTACIONAL
            //95	29	Préstamo Estacional para el Sector Pasivo de la Policía Boliviana con Cónyuge
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 95,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 95,
                    'procedure_document_id' => 423,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 95,
                    'procedure_document_id' => 297,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 95,
                    'procedure_document_id' => 422,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 95,
                    'procedure_document_id' => 272,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 95,
                    'procedure_document_id' => 367,
                    'number' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 95,
                    'procedure_document_id' => 424,
                    'number' => 6,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 95,
                    'procedure_document_id' => 418,
                    'number' => 7,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            //96	29	Préstamo Estacional para el Sector Pasivo de la Policía Boliviana
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 96,
                    'procedure_document_id' => 417,
                    'number' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 96,
                    'procedure_document_id' => 297,
                    'number' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 96,
                    'procedure_document_id' => 272,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 96,
                    'procedure_document_id' => 367,
                    'number' => 3,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 96,
                    'procedure_document_id' => 424,
                    'number' => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 96,
                    'procedure_document_id' => 418,
                    'number' => 5,
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
//php artisan db:seed --class=UpdateNewReglament2024Part2