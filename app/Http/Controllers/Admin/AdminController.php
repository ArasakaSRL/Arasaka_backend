<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Actions\Admin\GetAllSystemUsersAction;
use App\Http\Resources\UsuariosResource;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function indexAllUsuarios(GetAllSystemUsersAction $action, Request $request){
        $validated = $request->validate([
            "sortBy" => "nullable|in:nombre,created_at",
            "order" => "nullable|in:asc,desc"
        ]);

        $sortBy = $validated['sorrtBy'] ?? 'created_at';
        $order = $validated['order'] ?? 'desc';

        $usuarios = $action->execute($sortBy, $order);
        
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
