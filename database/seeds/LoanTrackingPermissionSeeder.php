<?php

use Illuminate\Database\Seeder;
use App\Permission;

class LoanTrackingPermissionSeeder extends Seeder
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
                'name' => 'show-delay-tracking',
                'display_name' => 'Ver seguimiento de mora de préstamo'
            ],[
                'name' => 'create-delay-tracking',
                'display_name' => 'Crear seguimiento de mora de préstamo'
            ],[
                'name' => 'update-delay-tracking',
                'display_name' => 'Actualizar seguimiento de mora de préstamo'
            ],[
                'name' => 'delete-delay-tracking',
                'display_name' => 'Eliminar seguimiento de mora de préstamo'
            ],[
                'name' => 'print-delay-tracking',
                'display_name' => 'Imprimir seguimiento de mora de préstamo'
            ]
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }
    }
}
