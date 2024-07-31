<?php

use Illuminate\Database\Seeder;
use App\RetirementFundAverage;
use App\Module;


class RetirementFundSAveragesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $averages = [
            [// COMANDANTE GRAL 85%
                'degree_id' => 1,
                'category_id' => 7,
                'retirement_fund_average' => 228065.76,
            ],[// COMANDANTE GRAL 100%
                'degree_id' => 1,
                'category_id' => 8,
                'retirement_fund_average' => 285082.20,
            ],[// INSPECTOR GENERAL 85%
                'degree_id' => 2,
                'category_id' => 7,
                'retirement_fund_average' => 228065.76,
                'is_active' => false
            ],[// INSPECTOR GENERAL 100%
                'degree_id' => 2,
                'category_id' => 8,
                'retirement_fund_average' => 285082.20,
                'is_active' => false
            ],[// GENERAL SUPERIOR 85%
                'degree_id' => 3,
                'category_id' => 7,
                'retirement_fund_average' => 228065.76,
            ],[// GENERAL SUPERIOR,  100%
                'degree_id' => 3,
                'category_id' => 8,
                'retirement_fund_average' => 285082.20,
            ],[// GENERAL MAYOR 85%
                'degree_id' => 4,
                'category_id' => 7,
                'retirement_fund_average' => 228065.76,
            ],[// GENERAL MAYOR 100%
                'degree_id' => 4,
                'category_id' => 8,
                'retirement_fund_average' => 285082.20,
            ],[// GENERAL PRIMERO 85%
                'degree_id' => 5,
                'category_id' => 7,
                'retirement_fund_average' => 228065.76,
            ],[// GENERAL PRIMERO 100%
                'degree_id' => 5,
                'category_id' => 8,
                'retirement_fund_average' => 285082.20,
            ],[// CORONEL Art.133 85%
                'degree_id' => 6,
                'category_id' => 7,
                'retirement_fund_average' => 197587.20,
            ],[// CORONEL Art.133 100%
                'degree_id' => 6,
                'category_id' => 8,
                'retirement_fund_average' => 246984.00,
            ],[// CORONEL 85%
                'degree_id' => 7,
                'category_id' => 7,
                'retirement_fund_average' => 197587.20,
            ],[// CORONEL 100%
                'degree_id' => 7,
                'category_id' => 8,
                'retirement_fund_average' => 246984.00,
            ],[// TENIENTE CORONEL 85%
                'degree_id' => 8,
                'category_id' => 7,
                'retirement_fund_average' => 179078.40,
            ],[// TENIENTE CORONEL 100%
                'degree_id' => 8,
                'category_id' => 8,
                'retirement_fund_average' => 223484.00,
            ], [// MAYOR 85%
                'degree_id' => 9,
                'category_id' => 7,
                'retirement_fund_average' => 158985.60,
            ],[//MAYOR 100%
                'degree_id' => 9,
                'category_id' => 8,
                'retirement_fund_average' => 198732.00,
            ],[// CAPITAN 85%
                'degree_id' => 10,
                'category_id' => 7,
                'retirement_fund_average' => 150076.80,
            ],[// CAPITAN 100%
                'degree_id' => 10,
                'category_id' => 8,
                'retirement_fund_average' => 187596.00,
            ],[// TENIENTE 85%
                'degree_id' => 11,
                'category_id' => 7,
                'retirement_fund_average' => 139680.00,
            ],[// TENIENTE 100%
                'degree_id' => 11,
                'category_id' => 8,
                'retirement_fund_average' => 174600.00,
            ],[// SUBTENIENTE 85%
                'degree_id' => 12,
                'category_id' => 7,
                'retirement_fund_average' => 135062.40,
            ],[// SUBTENIENTE 100%
                'degree_id' => 12,
                'category_id' => 8,
                'retirement_fund_average' => 168828.00,
            ],[// CORONEL DE SERVICIOS 85%
                'degree_id' => 13,
                'category_id' => 7,
                'retirement_fund_average' => 158069.76,
            ],[// CORONEL DE SERVICIOS 100%
                'degree_id' => 13,
                'category_id' => 8,
                'retirement_fund_average' => 197587.20,
            ],[// TENIENTE CORONEL DE SERVICIOS 85%
                'degree_id' => 14,
                'category_id' => 7,
                'retirement_fund_average' => 143262.72,
            ],[// TENIENTE CORONEL DE SERVICIOS 100%
                'degree_id' => 14,
                'category_id' => 8,
                'retirement_fund_average' => 179078.40,
            ],[// MAYOR DE SERVICIOS 85%
                'degree_id' => 15,
                'category_id' => 7,
                'retirement_fund_average' => 127188.48,
            ],[// MAYOR DE SERVICIOS 100%
                'degree_id' => 15,
                'category_id' => 8,
                'retirement_fund_average' => 158985.60,
            ],[// CAPITAN DE SERVICIOS 85%
                'degree_id' => 16,
                'category_id' => 7,
                'retirement_fund_average' => 120061.44,
            ],[// CAPITAN DE SERVICIOS 100%
                'degree_id' => 16,
                'category_id' => 8,
                'retirement_fund_average' => 150076.80,
            ],[// TENIENTE DE SERVICIOS 85%
                'degree_id' => 17,
                'category_id' => 7,
                'retirement_fund_average' => 111744.00,
            ],[// TENIENTE DE SERVICIOS 100%
                'degree_id' => 17,
                'category_id' => 8,
                'retirement_fund_average' => 139680.00,
            ],[// SUBTENIENTE DE SERVICIOS 85%
                'degree_id' => 18,
                'category_id' => 7,
                'retirement_fund_average' => 108049.92,
            ],[// SUBTENIENTE DE SERVICIOS 100%
                'degree_id' => 18,
                'category_id' => 8,
                'retirement_fund_average' => 135062.40,
            ],[// SUBOFICIAL SUPERIOR 85%
                'degree_id' => 19,
                'category_id' => 7,
                'retirement_fund_average' => 145819.20,
            ], [// SUBOFICIAL SUPERIOR 100%
                'degree_id' => 19,
                'category_id' => 8,
                'retirement_fund_average' => 182274.00,
            ],[// SUBOFICIAL MAYOR 85%
                'degree_id' => 20,
                'category_id' => 7,
                'retirement_fund_average' => 133948.80,
            ],[// SUBOFICIAL MAYOR 100%
                'degree_id' => 20,
                'category_id' => 8,
                'retirement_fund_average' => 167436.00,
            ],[// SUBOFICIAL PRIMERO 85%
                'degree_id' => 21,
                'category_id' => 7,
                'retirement_fund_average' => 130972.80,
            ],[// SUBOFICIAL PRIMERO 100%
                'degree_id' => 21,
                'category_id' => 8,
                'retirement_fund_average' => 163716.00,
            ], [// SUBOFICIAL SEGUNDO 85%
                'degree_id' => 22,
                'category_id' => 7,
                'retirement_fund_average' => 127123.20,
            ],[//SUBOFICIAL SEGUNDO 100%
                'degree_id' => 22,
                'category_id' => 8,
                'retirement_fund_average' => 158904.00,
            ],[// SARGENTO MAYOR 85%
                'degree_id' => 23,
                'category_id' => 7,
                'retirement_fund_average' => 125049.60,
            ],[// SARGENTO MAYOR 100%
                'degree_id' => 23,
                'category_id' => 8,
                'retirement_fund_average' => 156312.00,
            ],[// SARGENTO PRIMERO 85%
                'degree_id' => 24,
                'category_id' => 7,
                'retirement_fund_average' => 121296.00,
            ], [// SARGENTO PRIMERO 100%
                'degree_id' => 24,
                'category_id' => 8,
                'retirement_fund_average' => 151620.00,
            ],[// SARGENTO SEGUNDO 85%
                'degree_id' => 25,
                'category_id' => 7,
                'retirement_fund_average' => 120681.60,
            ],[// SARGENTO SEGUNDO 100%
                'degree_id' => 25,
                'category_id' => 8,
                'retirement_fund_average' => 150852.00,
            ],[// SARGENTO 85%
                'degree_id' => 26,
                'category_id' => 7,
                'retirement_fund_average' => 119942.40,
            ],[// SARGENTO 100%
                'degree_id' => 26,
                'category_id' => 8,
                'retirement_fund_average' => 149928.00,
            ],[// SUBOFICIAL SUPERIOR DE SERVICIOS 85%
                'degree_id' => 27,
                'category_id' => 7,
                'retirement_fund_average' => 116655.36,
            ],[// SUBOFICIAL SUPERIOR DE SERVICIOS 100%
                'degree_id' => 27,
                'category_id' => 8,
                'retirement_fund_average' => 145819.20,
            ],[// SUBOFICIAL MAYOR DE SERVICIOS 85%
                'degree_id' => 28,
                'category_id' => 7,
                'retirement_fund_average' => 107159.04,
            ],[// SUBOFICIAL MAYOR DE SERVICIOS 100%
                'degree_id' => 28,
                'category_id' => 8,
                'retirement_fund_average' => 133948.80,
            ],[// SUBOFICIAL PRIMERO DE SERVICIOS 85%
                'degree_id' => 29,
                'category_id' => 7,
                'retirement_fund_average' => 104778.24,
            ],[// SUBOFICIAL PRIMERO DE SERVICIOS 100%
                'degree_id' => 29,
                'category_id' => 8,
                'retirement_fund_average' => 130972.80,
            ],[// SUBOFICIAL SEGUNDO DE SERVICIOS 85%
                'degree_id' => 30,
                'category_id' => 7,
                'retirement_fund_average' => 101698.56,
            ],[// SUBOFICIAL SEGUNDO DE SERVICIOS 100%
                'degree_id' => 30,
                'category_id' => 8,
                'retirement_fund_average' => 127123.20,
            ],[// SARGENTO MAYOR DE SERVICIOS 85%
                'degree_id' => 31,
                'category_id' => 7,
                'retirement_fund_average' => 100039.68,
            ],[// SARGENTO MAYOR DE SERVICIOS 100%
                'degree_id' => 31,
                'category_id' => 8,
                'retirement_fund_average' => 125049.60,
            ],[// SARGENTO PRIMERO DE SERVICIOS 85%
                'degree_id' => 32,
                'category_id' => 7,
                'retirement_fund_average' => 97036.80,
            ],[// SARGENTO PRIMERO DE SERVICIOS 100%
                'degree_id' => 32,
                'category_id' => 8,
                'retirement_fund_average' => 121296.00,
            ],[// SARGENTO SEGUNDO DE SERVICIOS 85%
                'degree_id' => 33,
                'category_id' => 7,
                'retirement_fund_average' => 96545.28,
            ],[// SARGENTO SEGUNDO DE SERVICIOS 100%
                'degree_id' => 33,
                'category_id' => 8,
                'retirement_fund_average' => 120681.60,
            ],[// SARGENTO DE SERVICIOS 85%
                'degree_id' => 34,
                'category_id' => 7,
                'retirement_fund_average' => 95953.92,
            ],[// SARGENTO DE SERVICIOS 100%
                'degree_id' => 34,
                'category_id' => 8,
                'retirement_fund_average' => 119942.40,
            ]
        ];
        foreach ($averages as $average) {
            RetirementFundAverage::Create($average);
        }
    }
}
