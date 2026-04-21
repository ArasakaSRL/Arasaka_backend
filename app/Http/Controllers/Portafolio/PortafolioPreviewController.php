<?php

namespace App\Http\Controllers\Portafolio;

use App\Actions\Portafolio\ObtenerPortafolioPreviewAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Portafolio\PublicPortafolioResource;

class PortafolioPreviewController extends Controller
{
    public function __construct(
        private ObtenerPortafolioPreviewAction $action
    ) {}

    public function show(string $slug)
    {
        $portafolio = $this->action->execute($slug, auth()->id());

        if (!$portafolio) {
            return response()->json([
                'mensaje' => 'Portafolio no encontrado',
                'codigo' => 'no_disponible',
            ], 404);
        }

        return new PublicPortafolioResource($portafolio);
    }
}
