<?php

use Illuminate\Database\Seeder;
use App\Permission;

class LoanCertificationPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'print-loan-certification',
                'display_name' => 'Imprimir certificación de devolución a garante'
            ]
        ];
        foreach($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }
    }
}
