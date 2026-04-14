<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\Portafolio\PublicPortafolioResource;
use App\Actions\Portafolio\ObtenerPortafolioPublicoAction;

class PublicPortafolioController extends Controller
{
    public function __construct(
        private ObtenerPortafolioPublicoAction $action
    ) {}

    public function show(string $slug)
    {
        $portafolio = $this->action->execute($slug);

        if (!$portafolio) {
            return response()->json([
                'mensaje' => 'Portafolio no encontrado',
                'slug' => $slug
            ], 404);
        }

        return new PublicPortafolioResource($portafolio);
    }
}