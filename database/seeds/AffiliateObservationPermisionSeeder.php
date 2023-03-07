<?php

use Illuminate\Database\Seeder;
use App\Permission;

class AffiliateObservationPermisionSeeder extends Seeder
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
                'name' => 'show-observation-affiliate',
                'display_name' => 'Ver observaciones del afiliado'
            ],[
                'name' => 'create-observation-affiliate',
                'display_name' => 'Crear observaciones del afiliado'
            ],[
                'name' => 'update-observation-affiliate',
                'display_name' => 'Actualizar observaciones del afiliado'
            ],[
                'name' => 'delete-observation-affiliate',
                'display_name' => 'Eliminar observaciones del afiliado'
            ]
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }
    }
}
