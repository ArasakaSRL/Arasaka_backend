<?php

namespace App\Console\Commands;

use App\Models\Portafolio;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Console\Command;

class LevantarSuspensiones extends Command
{
    protected $signature   = 'suspensiones:levantar';
    protected $description = 'Reactiva portafolios y usuarios cuya suspensión temporal ha vencido';

    public function handle(): void
    {
        $ahora = Carbon::now();

        $portafolios = Portafolio::where('suspendido', true)
            ->whereNotNull('suspendido_hasta')
            ->where('suspendido_hasta', '<=', $ahora)
            ->get();

        foreach ($portafolios as $portafolio) {
            $portafolio->update(['suspendido' => false, 'suspendido_hasta' => null]);
        }

        $this->info("Portafolios reactivados: {$portafolios->count()}");

        $usuarios = Usuario::where('suspendido', true)
            ->whereNotNull('suspendido_hasta')
            ->where('suspendido_hasta', '<=', $ahora)
            ->get();

        foreach ($usuarios as $usuario) {
            $usuario->update(['suspendido' => false, 'suspendido_hasta' => null]);
        }

        $this->info("Usuarios reactivados: {$usuarios->count()}");
    }
}
