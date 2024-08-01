<?php

use Illuminate\Database\Seeder;
use App\ProcedureType;
use App\RoleSequence;
use App\Role;

class RoleSequence2024Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Flujo de Préstamo al Sector Activo con Garantía del Beneficio Fondo de Retiro Policial Solidario
        RoleSequence::flushEventListeners();
        $sequences = [
            'Préstamo al Sector Activo con Garantía del Beneficio Fondo de Retiro Policial Solidario' => [
                ['PRE-plataforma'],
                ['PRE-calificacion'],
                ['PRE-aprobacion-jefatura'],
                ['PRE-confirmación legal'],
                ['PRE-presupuesto'],
                ['PRE-contabilidad'],
                ['PRE-tesoreria'],
                ['PRE-archivo'],
            ]
        ];
        $this->create($sequences);

        // Flujo de Préstamo Estacional para el Sector Pasivo de la Policía Boliviana
        $sequences = [
            'Préstamo Estacional para el Sector Pasivo de la Policía Boliviana' => [
                ['PRE-plataforma'],
                ['PRE-calificacion'],
                ['PRE-aprobacion-jefatura'],
                ['PRE-confirmación legal'],
                ['PRE-presupuesto'],
                ['PRE-contabilidad'],
                ['PRE-tesoreria'],
                ['PRE-archivo'],
            ]
        ];
        $this->create($sequences);

        // Flujo de Reprogramación del Refinanciamiento Préstamo a Corto Plazo
        $sequences = [
            'Reprogramación del Refinanciamiento Préstamo a Corto Plazo' => [
                ['PRE-plataforma'],
                ['PRE-calificacion'],
                ['PRE-cobranzas-corte'],
                ['PRE-revision-calificacion'],
                ['PRE-aprobacion-jefatura'],
                ['PRE-confirmación legal'],
                ['PRE-archivo'],
            ]
        ];
        $this->create($sequences);

        // Flujo de Reprogramación del Refinanciamiento Préstamo a Largo Plazo
        $sequences = [
            'Reprogramación del Refinanciamiento Préstamo a Largo Plazo' => [
                ['PRE-plataforma'],
                ['PRE-calificacion'],
                ['PRE-cobranzas-corte'],
                ['PRE-revision-calificacion'],
                ['PRE-aprobacion-jefatura'],
                ['PRE-confirmación legal'],
                ['PRE-archivo'],
            ]
        ];
        $this->create($sequences);

        // Flujo de Reprogramación Préstamo a Corto Plazo
        $sequences = [
            'Reprogramación Préstamo a Corto Plazo' => [
                ['PRE-plataforma'],
                ['PRE-calificacion'],
                ['PRE-cobranzas-corte'],
                ['PRE-revision-calificacion'],
                ['PRE-aprobacion-jefatura'],
                ['PRE-confirmación legal'],
                ['PRE-archivo'],
            ]
        ];
        $this->create($sequences);

        // Flujo de Reprogramación Préstamo a Largo Plazo
        $sequences = [
            'Reprogramación Préstamo a Largo Plazo' => [
                ['PRE-plataforma'],
                ['PRE-calificacion'],
                ['PRE-cobranzas-corte'],
                ['PRE-revision-calificacion'],
                ['PRE-aprobacion-jefatura'],
                ['PRE-confirmación legal'],
                ['PRE-archivo'],
            ]
        ];
        $this->create($sequences);
    }

    public function create($sequences)
    {
        foreach ($sequences as $procedure_type => $sequence) {
            $procedure = ProcedureType::whereName($procedure_type)->first();
            foreach ($sequence as $i => $current) {
                if ($i > 0) {
                    $j = $i;
                    foreach ($current as $next_role) {
                        $previous = $sequence[$i - 1];
                        $curr = Role::whereName($next_role)->first();
                        foreach ($previous as $role) {
                            $prev = Role::whereName($role)->first();
                            if ($curr && $prev) {
                                RoleSequence::firstOrCreate([
                                    'procedure_type_id' => $procedure->id,
                                    'role_id' => $prev->id,
                                    'next_role_id' => $curr->id,
                                    'sequence_number_flow' => $j
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }
}
