<?php

namespace App\Services\Proyecto;

use App\Models\Proyecto;
use Illuminate\Support\Str;

class ProyectoService {
    public function crear($data ,$idPortafolio){
        //dd($data, $idPortafolio);
        $proyecto = Proyecto::create([
            'id_proyecto' => Str::uuid(),
            'id_portafolio' => $idPortafolio,
            ...$data
        ]);
        $proyecto->tecnologias()->sync($data['tecnologias']);
        /* $url_imagen = collect($data['url_imagen'])->map(fn($url_imagen) => [
            'url_imagen' => $url_imagen
        ])->toArray();
        $proyecto->imagenes()->createMany($url_imagen); */
        return $proyecto;
    }

    public function actualizar(array $data, $id){
        $proyecto = Proyecto::findOrFail($id);
        $proyecto->update(array_merge($data,[
            'fecha_actualizacion'=> now()
        ]));
        
        
        // 1. Verificamos que la llave exista
        if (array_key_exists('tecnologias', $data) && is_array($data['tecnologias'])) {
        
        // 2. Limpiamos cadenas vacías, nulos o espacios en blanco
            $tecnologiasLimpias = array_filter($data['tecnologias'], function($valor) {
                return !empty(trim($valor)); 
            });

        // 3. Sincronizamos las tecnologías (elimina las no presentes, añade las nuevas)
            $proyecto->tecnologias()->sync($tecnologiasLimpias);
        }
        /* ACTUALIZAR IMAGENES */
        if (array_key_exists('url_imagen', $data) && is_array($data['url_imagen'])) {
            $proyecto->imagenes()->delete();
        
        // 2. Limpiamos cadenas vacías, nulos o espacios en blanco
            $urlsLimpias = array_filter($data['url_imagen'], function($valor) {
                return !empty(trim($valor)); 
            });

            $urls = collect($urlsLimpias)->map(fn($url_imagen) => [
                'url_imagen' => $url_imagen
            ])->toArray();

        // 3. Solo sincronizamos si el array NO quedó vacío tras la limpieza
            if (!empty($urls)) {
                $proyecto->imagenes()->createMany($urls);
            }
        }
        
        return $proyecto;
    }

    public function eliminar(Proyecto $proyecto){
        $proyecto->delete();
    }
}