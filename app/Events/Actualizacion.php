<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Actualizacion implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $datosActualizacion;
    public $tipoActualizacion;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($datosActualizacion,$tipoActualizacion)
    {
        $this->datosActualizacion=$datosActualizacion;
        $this->tipoActualizacion=$tipoActualizacion;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new channel('update');
    }

    
}
