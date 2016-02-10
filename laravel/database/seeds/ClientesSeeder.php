<?php

use Illuminate\Database\Seeder;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CuentasFacturas\Clientes::class)->create([
            'identificacion' => '1301301309',
            'nombres' => 'Cliente',
            'apellidos' => 'Prueba',
            'correo' => 'diana@mail.com',
            'telefono' => '052256369',
            'direccion' => 'manta'
        ]);

        factory(CuentasFacturas\Clientes::class, 50)->create();
    }
}
