<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Actions\Admin\GetAllSystemUsersAction;
use App\Http\Resources\UsuariosResource;

class AdminController extends Controller
{
    public function indexAllUsuarios(GetAllSystemUsersAction $action){
        $usuarios = $action->execute();
        //dd($usuarios);
        $count = $usuarios->count();
        if($usuarios){
            $data = [
                'message' => 'Usuarios obtenidos correctamente',
                'count' => $count,
                'data' => UsuariosResource::collection($usuarios)
            ];
            return response()->json($data, 200);
        }else{
            return response()->json(['message' => 'Error al obtener usuarios'], 200);
        }
    }
}
