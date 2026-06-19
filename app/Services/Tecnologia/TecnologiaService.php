<?php

namespace App\Services\Tecnologia;

use App\Models\Tecnologia;
use Illuminate\Http\Exceptions\HttpResponseException;
class TecnologiaService
{
    public function listar($cantidad = 9)
    {
        return Tecnologia::orderBy('nombre', 'asc')
            ->paginate($cantidad);
    }

public function crear(array $data)
{
    $existe = Tecnologia::whereRaw(
        'LOWER(nombre) = ?',
        [strtolower(trim($data['nombre']))]
    )->exists();

    if ($existe) {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'El nombre de la tecnología ya está en uso.',
            'data' => null
        ], 422));
    }

    if (empty($data['logo'])) {
        $data['logo'] = 'https://firebasestorage.googleapis.com/v0/b/arasaka-tis.firebasestorage.app/o/tecnologias%2F945529.png?alt=media&token=41dc7bf9-fed8-49f9-9016-dcc068022a19';
    }

    Tecnologia::create($data);

    return Tecnologia::orderBy('nombre', 'asc')
        ->paginate(9);
}

    public function mostrar(string $id)
    {
        return Tecnologia::findOrFail($id);
    }

    public function actualizar(string $id, array $data)
    {
        $tecnologia = Tecnologia::findOrFail($id);

        $tecnologia->update($data);

        return Tecnologia::orderBy('nombre', 'asc')
            ->paginate(9);
    }

    public function eliminar(string $id)
    {
        $tecnologia = Tecnologia::findOrFail($id);

        $tecnologia->delete();

        return Tecnologia::orderBy('nombre', 'asc')
            ->paginate(9);
    }
}