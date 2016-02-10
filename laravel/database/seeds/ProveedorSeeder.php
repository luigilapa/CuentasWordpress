<?php

use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CuentasFacturas\Proveedores::class)->create([
            'identificacion' => '1301301309',
            'nombres' => 'Proveedor',
            'correo' => 'proveedor@mail.com',
            'telefono' => '052256369',
            'direccion' => 'manta'
        ]);

        factory(CuentasFacturas\Proveedores::class, 50)->create();
    }
}
