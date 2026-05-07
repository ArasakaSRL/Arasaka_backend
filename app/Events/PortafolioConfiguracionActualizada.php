<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PortafolioConfiguracionActualizada implements ShouldBroadcast
{
    public $id_portafolio;
    public $configuracion;

    public function __construct($id_portafolio, $configuracion)
    {
        $this->id_portafolio = $id_portafolio;
        $this->configuracion = $configuracion;
    }

    public function broadcastOn()
    {
        return new Channel('portafolio.' . $this->id_portafolio);
    }

    public function broadcastAs()
    {
        return 'configuracion.actualizada';
    }
}