<?php

use Illuminate\Database\Seeder;
use App\ProcedureModality;

class AmortizationSeasonTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payment_types = [
            [
                'procedure_type_id' => 23,
                'name' => 'Prestamo Estacional',
                'shortened' => 'AMR-EST',
                'is_valid' => true
            ]
        ];
        foreach ($payment_types as $payment_type) {
            ProcedureModality::firstOrCreate($payment_type);
        }
    }
}
