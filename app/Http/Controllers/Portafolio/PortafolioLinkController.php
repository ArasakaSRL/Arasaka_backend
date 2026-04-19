<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use App\Models\Portafolio;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PortafolioLinkController extends Controller
{
    private const DURACIONES = ['semana', 'mes', 'anio', 'sin_limite'];

    public function show()
    {
        $portafolio = Portafolio::where('id_usuario', auth()->id())->first();

        if (!$portafolio) {
            return response()->json(['mensaje' => 'Portafolio no encontrado'], 404);
        }

        return response()->json($this->formatear($portafolio));
    }

    public function generar(Request $request)
    {
        $request->validate([
            'duracion' => ['required', Rule::in(self::DURACIONES)],
        ]);

        $usuario = Usuario::find(auth()->id());
        $portafolio = Portafolio::where('id_usuario', $usuario->id_usuario)->first();

        if (!$portafolio) {
            return response()->json(['mensaje' => 'Portafolio no encontrado'], 404);
        }

        $slugBase = Str::slug(trim($usuario->nombre . '-' . $usuario->apellido));

        if ($slugBase === '') {
            $slugBase = 'portafolio';
        }

        $portafolio->slug = $this->generarSlugUnico($slugBase, $portafolio->id_portafolio);
        $portafolio->duracion_link = $request->duracion;
        $portafolio->fecha_expiracion_link = $this->calcularExpiracion($request->duracion);
        $portafolio->link_activo = true;
        $portafolio->visibilidad = true;
        $portafolio->fecha_actualizacion = now();
        $portafolio->save();

        return response()->json($this->formatear($portafolio));
    }

    private function generarSlugUnico(string $base, string $idActual): string
    {
        $slug = $base;
        $intentos = 0;

        while (
            Portafolio::where('slug', $slug)
                ->where('id_portafolio', '!=', $idActual)
                ->exists()
        ) {
            $intentos++;
            $sufijo = $intentos > 3 ? Str::lower(Str::random(4)) : (string) $intentos;
            $slug = "{$base}-{$sufijo}";
        }

        return $slug;
    }

    private function calcularExpiracion(string $duracion): ?\Carbon\Carbon
    {
        return match ($duracion) {
            'semana' => now()->addWeek(),
            'mes' => now()->addMonth(),
            'anio' => now()->addYear(),
            'sin_limite' => null,
            default => now()->addWeek(),
        };
    }

    private function formatear(Portafolio $portafolio): array
    {
        $frontendUrl = config('app.frontend_url', env('FRONTEND_URL', 'http://localhost:5173'));

        return [
            'slug' => $portafolio->slug,
            'url' => $portafolio->link_activo
                ? rtrim($frontendUrl, '/') . '/portfolio/' . $portafolio->slug
                : null,
            'link_activo' => (bool) $portafolio->link_activo,
            'duracion' => $portafolio->duracion_link,
            'fecha_expiracion' => $portafolio->fecha_expiracion_link,
            'expirado' => $portafolio->fecha_expiracion_link
                ? $portafolio->fecha_expiracion_link->isPast()
                : false,
        ];
    }
}
