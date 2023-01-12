<?php

use Illuminate\Database\Seeder;
use App\LoanProcedure;

class LoanProcedureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $loan_porcedures = [
            ['description'=>'Reglamento de Préstamos 2019','start_production_date'=>'04-06-2021','is_enable'=>false],
            ['description'=>'Reglamento de Préstamos 2022','start_production_date'=>'16-01-2023','is_enable'=>true],
            ];
            foreach ($loan_porcedures as $loan_porcedure) {
                LoanProcedure::firstOrCreate($loan_porcedure);
            }
    }
}
