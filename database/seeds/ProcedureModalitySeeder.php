<?php

use Illuminate\Database\Seeder;

use App\ProcedureModality;

class ProcedureModalitySeeder extends Seeder

{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $procedure_modalities = [
        //Creacion de Nuevas Modalidades
        ['procedure_type_id'=>12,'name'=>'Largo Plazo con Garantía Personal Servicio Activo Comisión','shortened'=>'LAR-ACT-COM','is_valid'=>true ],
        ['procedure_type_id'=>12,'name'=>'Largo Plazo con Garantía Personal Servicio en Disponibilidad','shortened'=>'LAR-DIS','is_valid'=>true ],
        ];
        foreach ($procedure_modalities as $procedure_modality) {
            ProcedureModality::firstOrCreate($procedure_modality);
        }
        //Actualizacion de Miodalidades
        $procedureModality = ProcedureModality::where('name','Largo Plazo con un Solo Garante Sector Activo CPOP')->first();
        if(isset($procedureModality)){
        $procedureModality->name ="Largo Plazo con un Solo Garante Sector Activo";
        $procedureModality->shortened ="LAR-1G";
        $procedureModality->update();
        }
        $procedureModalityRef = ProcedureModality::where('name','Refinanciamiento de Préstamo a largo Plazo con un Solo Garante Sector Activo CPOP')->first();
        if(isset($procedureModalityRef)){
        $procedureModalityRef->name ="Refinanciamiento de Préstamo a Largo Plazo con un Solo Garante Sector Activo";
        $procedureModalityRef->shortened ="REF-LAR-1G";
        $procedureModalityRef->update();
        }
    }
}
