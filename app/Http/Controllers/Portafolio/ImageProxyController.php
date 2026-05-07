<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ImageProxyController extends Controller
{
    /**
     * Proxy de imágenes para sortear CORS de Firebase Storage al generar el CV.
     * Solo acepta URLs de hosts permitidos.
     */
    public function fetch(Request $request)
    {
        $url = $request->query('url');

        if (!$url || !is_string($url)) {
            return response()->json(['error' => 'url requerida'], 400);
        }

        $parsed = parse_url($url);
        $host = $parsed['host'] ?? null;

        $allowedHosts = [
            'firebasestorage.googleapis.com',
            'storage.googleapis.com',
            'lh3.googleusercontent.com',
        ];

        if (!$host || !in_array($host, $allowedHosts, true)) {
            return response()->json(['error' => 'host no permitido'], 403);
        }

        try {
            $response = Http::timeout(15)->get($url);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'fallo al descargar'], 502);
        }

        if (!$response->successful()) {
            return response()->json(['error' => 'recurso no disponible'], $response->status());
        }

        $contentType = $response->header('Content-Type') ?: 'application/octet-stream';

        return response($response->body(), 200)
            ->header('Content-Type', $contentType)
            ->header('Cache-Control', 'public, max-age=3600');
    }
}
