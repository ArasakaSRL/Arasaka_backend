<?php

namespace App\Http\Resources\Portafolio;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicPortafolioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_portafolio,
            'nombre' => $this->nombre,
            'slug' => $this->slug,
            'descripcion' => $this->descripcion,
            'visibilidad' => $this->visibilidad,

            'usuario' => [
                'id' => $this->usuario?->id_usuario,
                'nombre' => $this->informacionBasica?->nombre_completo ?? ($this->usuario?->nombre . ' ' . $this->usuario?->apellido),
                'correo' => $this->informacionBasica?->gmail ?? $this->usuario?->correo,
                'biografia' => $this->informacionBasica?->biografia,
                'foto_perfil' => $this->informacionBasica?->foto_perfil ?? $this->usuario?->url_foto,
                'pais' => $this->informacionBasica?->pais,
                'telefonos' => $this->telefonos->map(fn($t) => [
                    'numero' => $t->telefono,
                ]),
                'profesiones' => $this->profesiones,
                'idiomas' => $this->idiomas,
            ],
            'informacion_basica' => $this->informacionBasica,

            'proyectos' => $this->proyectos ->take(5) -> map(fn($p) => [
                'id_proyecto' => $p->id_proyecto,
                'nombre' => $p->nombre,
                'descripcion' => $p->descripcion,
                'estados' => $p->estados,
                'url_demo' => $p->url_demo,
                'url_repositorio' => $p->url_github,
                'imagenes' => $p->imagenes->map(fn($i) => [
                    'url' => $i->url_imagen,
                ]),
                'tecnologias' => $p->tecnologias ->map(fn($t) => [
                    'nombre' => $t->nombre,
                    'descripcion' => $t->descripcion,
                    'logo' => $t->logo,
                    'categoria' => $t->categorias?->nombre,
                ]),
            ]),
             'habilidades' => [
               'tecnicas' => $this->habilidades
                ->filter(fn($h) => $h->categoria_habilidad?->value === 'tecnica')
                ->take(8)
                ->map(fn($h) => [
                'id_habilidad' => $h->id_habilidad,
                'nombre' => $h->nombre,
                'descripcion' => $h->descripcion,
                'nivel' => $h->nivel?->value,
                'tecnologias' => $h->tecnologias->map(fn($t) => [
                    'nombre' => $t->nombre,
                    'descripcion' => $t->descripcion,
                    'logo' => $t->logo,
                    'categoria' => $t->categoria?->nombre,
                ]),
           ])
        ->values(),

               'blandas' => $this->habilidades
               ->filter(fn($h) => $h->categoria_habilidad?->value === 'blanda')
               ->take(8)
               ->map(fn($h) => [
               'id_habilidad' => $h->id_habilidad,
               'nombre' => $h->nombre,
               'descripcion' => $h->descripcion,
               'nivel' => $h->nivel?->value,
            ])
             ->values(),
            ],
            'experiencias' => $this->experiencias ->take(4) ->map(fn($e) => [
                'id_experiencia' => $e->id_experiencia,
                'cargo' => $e->cargo,
                'Nombre_empresa' => $e->nombre_organizacion,
                'descripcion' => $e->descripcion,
                'fecha_inicio' => $e->fecha_inicio, 
                'fecha_fin' => $e->fecha_fin,
                'tipo' => $e->tipo?->nombre,
                'vigencia' => $e->vigencia,
            ]),
            'servicios' => $this->servicios ->take(5) ->map(fn($s) => [
                'id_servicio' => $s->id_servicio,
                'nombre' => $s->nombre,
                'descripcion' => $s->descripcion,
            ]),
            'certificaciones' => $this->certificaciones ->take(5) ->map(fn($c) => [
                'id_certificacion' => $c->id_certificacion,
                'titulo' => $c->titulo,
                'descripcion' => $c->descripcion,
                'institucion' => $c->institucion_emisora,
                'fecha_emision' => $c->fecha_obtencion,
                'url_certificado' => $c->url_archivo,
                'categoria' => $c->categoria?->nombre,
                'orientacion' => $c->orientacion_imagen,
            ]),
            'redes_profesionales' => $this->redesProfesionales ->take(5) ->map(fn($r) => [
                'id_red_profesional' => $r->id_red,
                'nombre' => $r->nombre,
                'url_Red' => $r->url,
            ]),
            'formacion_academica' => $this->formacion_academica ->take(5) ->map(fn($f) => [
                'id_formacion_academica' => $f->id_formacion_academica,
                'institucion' => $f->institucion,
                'titulo' => $f->titulo,
                'nivel' => $f->nivel,
                'fecha_inicio' => $f->fecha_inicio,
                'fecha_fin' => $f->fecha_fin,
                'descripcion' => $f->descripcion,
            ]),
            'configuracion' => $this->configuracion ? [
                'mostrar_proyectos' => $this->configuracion->mostrar_proyecto,
                'mostrar_habilidades' => $this->configuracion->mostrar_habilidades,
                'mostrar_experiencias' => $this->configuracion->mostrar_experiencia,
                'mostrar_servicios' => $this->configuracion->mostrar_servicios,
                'mostrar_certificaciones' => $this->configuracion->mostrar_certificaciones,
                'mostrar_redes_profesionales' => $this->configuracion->mostrar_redes_profesionales,
                'mostrar_cv' => $this->configuracion->mostrar_cv,
                'mostrar_contacto' => $this->configuracion->mostrar_contacto,
                'paleta_colores' => $this->configuracion->paleta_colores,
                'plantilla' => $this->configuracion->plantilla ?? 'predeterminado',
            ] : null,
        ];
    }
}