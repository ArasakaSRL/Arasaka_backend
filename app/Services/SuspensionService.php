<?php

namespace App\Services;

use App\Models\Portafolio;
use App\Models\SystemConfig;
use App\Models\Usuario;
use App\Notifications\AdvertenciaPortafolioNotification;
use App\Notifications\SuspensionPortafolioNotification;
use App\Notifications\AdvertenciaUsuarioNotification;
use App\Notifications\SuspensionUsuarioNotification;
use Carbon\Carbon;

class SuspensionService
{
    public function evaluarPortafolio(Portafolio $portafolio): void
    {
        if ($portafolio->suspendido) return;

        $config         = SystemConfig::get();
        $totalDenuncias = $portafolio->denuncias()->count();

        if ($totalDenuncias >= $config->denuncias_suspension) {
            $hasta = Carbon::now()->addDays($config->dias_suspension_portafolio);
            $portafolio->update(['suspendido' => true, 'suspendido_hasta' => $hasta]);

            $usuario = $portafolio->usuario;
            $usuario->notify(new SuspensionPortafolioNotification($portafolio->nombre, $hasta));

            $this->evaluarUsuario($usuario);
            return;
        }

        if ($totalDenuncias >= $config->denuncias_advertencia) {
            $portafolio->usuario->notify(
                new AdvertenciaPortafolioNotification($portafolio->nombre)
            );
        }
    }

    public function evaluarUsuario(Usuario $usuario): void
    {
        if ($usuario->suspendido) return;

        $config           = SystemConfig::get();
        $totalSuspendidos = $usuario->portafolios()
            ->where('suspendido', true)
            ->count();

        if ($totalSuspendidos >= $config->portafolios_suspension) {
            $hasta = Carbon::now()->addDays($config->dias_suspension_usuario);
            $usuario->update(['suspendido' => true, 'suspendido_hasta' => $hasta]);
            $usuario->notify(new SuspensionUsuarioNotification($hasta));
            return;
        }

        if ($totalSuspendidos >= $config->portafolios_advertencia) {
            $usuario->notify(new AdvertenciaUsuarioNotification());
        }
    }
}
