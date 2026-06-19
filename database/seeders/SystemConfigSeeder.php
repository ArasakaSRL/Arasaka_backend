<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemConfigSeeder extends Seeder
{
    public function run(): void
    {
        $existe = DB::table('configuracion_sistema')->exists();
        if (!$existe) {
            DB::table('configuracion_sistema')->insert([
                'denuncias_advertencia'  => 8,
                'denuncias_suspension'   => 10,
                'portafolios_advertencia' => 2,
                'portafolios_suspension'  => 3,
            ]);
        }
    }
}
