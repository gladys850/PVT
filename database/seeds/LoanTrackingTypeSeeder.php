<?php

use Illuminate\Database\Seeder;
use App\LoanTrackingType;

class LoanTrackingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tracking_loans_types = [
            [
                'sequence_number' => 1,
                'name' => 'LLamadas telefónicas al deudor y/o garante(s)',
            ],
            [
                'sequence_number' => 2,
                'name' => 'Publicación de nómina de prestatarios en situación de mora',
            ],
            [
                'sequence_number' => 3,
                'name' => 'Solicitud de información de situación laboral al comando general de la policía boliviana',
            ],
            [
                'sequence_number' => 4,
                'name' => 'Solicitud de información a dirección de beneficios económicos',
            ],
            [
                'sequence_number' => 5,
                'name' => 'Solicitud de la carpeta a archivo central',
            ],
            [
                'sequence_number' => 6,
                'name' => 'Elaboración de carta de cobro administrativo',
            ],
            [
                'sequence_number' => 7,
                'name' => 'Carta de cobro administrativo notificada',
            ],
            [
                'sequence_number' => 8,
                'name' => 'Elaboración de informe técnico de recuperación de cartera en mora',
            ],
            [
                'sequence_number' => 9,
                'name' => 'Se remite al área legal - DESI',
            ]

        ];
        foreach($tracking_loans_types as $tracking_loans_type) {
            LoanTrackingType::firstOrCreate($tracking_loans_type);
        }
    }
}
