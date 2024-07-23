<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateRequirementsReglament2024 extends Seeder
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

            //CREACIÓN DEL NUEVO DOCUMENTO
            DB::table('procedure_documents')->insert([
                [
                    'name' => 'Última boleta de pago cargada en el sistema PVT.',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //ADICIÓN DEL NUEVO REQUISITO

            //ANTICPO SECTOR ACTIVO
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 32,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //ANTICPO EN DISPONIBILIDAD
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 33,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //CORTO PLAZO SECTOR ACTIVO
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 36,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //CORTO PLAZO DISPONIBILIDAD
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 37,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //REFINANCIAMIENTO CORTO PLAZO SECTOR ACTIVO
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 40,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //REFINANCIAMIENTO CORTO PLAZO EN DISPONIBILIDAD
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 66,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //REPROGRAMACIÓN CORTO PLAZO SECTOR ACTIVO
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 73,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //REPROGRAMACIÓN CORTO PLAZO EN DISPONIBILIDAD
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 74,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //REPROGRAMACIÓN DEL REFINANCIAMIENTO CORTO PLAZO SECTOR ACTIVO
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 77,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //REPROGRAMACIÓN DEL REFINANCIAMIENTO CORTO PLAZO EN DISPONIBILIDAD
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 78,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //LARGO PLAZO CGP SECTOR ACTIVO CON UN GARANTE
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 81,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //LARGO PLAZO CGP SECTOR ACTIVO CON DOS GARANTES
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 43,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //LARGO PLAZO CON PAGO OPROTUNO
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 46,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //LARGO PLAZO CGP EN DISPONIBILIDAD CON UN GARANTE
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 97,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //LARGO PLAZO CGP EN DISPONIBILIDAD CON DOS GARANTES
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 65,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //REFINANCIAMIENTO LARGO PLAZO CGP SECTOR ACTIVO CON UN GARANTE
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 82,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //REFINANCIAMIENTO LARGO PLAZO CGP SECTOR ACTIVO CON DOS GARANTES
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 47,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //REFINANCIAMIENTO LARGO PLAZO CON PAGO OPORTUNO
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 50,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //REFINANCIAMIENTO LARGO PLAZO CGP EN DISPONIBILIDAD CON UN GARANTE
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 98,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //REFINANCIAMIENTO LARGO PLAZO CGP EN DISPONIBILIDAD CON DOS GARANTES
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 99,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //REPROGRAMACIÓN LARGO PLAZO CGP SECTOR ACTIVO CON UN GARANTE
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 83,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //REPROGRAMACIÓN LARGO PLAZO CGP SECTOR ACTIVO CON DOS GARANTES
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 84,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //REPROGRAMACIÓN LARGO PLAZO CGP CON PAGO OPORTUNO
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 85,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //REPROGRAMACIÓN DEL REFINANCIAMIENTO LARGO PLAZO CGP SECTOR ACTIVO CON UN GARANTE
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 88,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //REPROGRAMACIÓN DEL REFINANCIAMIENTO LARGO PLAZO CGP SECTOR ACTIVO CON DOS GARANTES
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 89,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //REPROGRAMACIÓN DEL REFINANCIAMIENTO LARGO PLAZO CON PAGO OPORTUNO
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 90,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //PORBENEFICIO DEL FONDO DE RETIRO MENOR
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 93,
                    'procedure_document_id' => 430,
                    'number' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            //PORBENEFICIO DEL FONDO DE RETIRO MAYOR
            DB::table('procedure_requirements')->insert([
                [
                    'procedure_modality_id' => 94,
                    'procedure_document_id' => 430,
                    'number' => 2,
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
//php artisan db:seed --class=UpdateRequirementsReglament2024