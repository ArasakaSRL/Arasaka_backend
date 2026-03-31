<?php

namespace App\Services\Profesion;

use App\Models\Profesion;
use App\Models\Usuario;
use Illuminate\Support\Str;

class ProfesionService
{
    public function getAll()
    {
        return Profesion::all();
    }

    public function getById(string $id)
    {
        return Profesion::findOrFail($id);
    }

    public function create(array $data): Profesion
    {
        return Profesion::create([
            'id_profesion' => (string) Str::uuid(),
            ...$data,
        ]);
    }

    public function update(Profesion $profesion, array $data): Profesion
    {
        $profesion->update($data);
        return $profesion->fresh();
    }

    public function delete(Profesion $profesion): void
    {
        $profesion->delete();
    }

    public function getProfesionesDeUsuario(Usuario $usuario)
    {
        return $usuario->profesiones;
    }

    public function asignarProfesion(Usuario $usuario, string $idProfesion): void
    {
        $this->getById($idProfesion); // throws 404 if not found
        $usuario->profesiones()->syncWithoutDetaching([$idProfesion]);
    }

    public function desasignarProfesion(Usuario $usuario, string $idProfesion): void
    {
        $usuario->profesiones()->detach($idProfesion);
    }
}
