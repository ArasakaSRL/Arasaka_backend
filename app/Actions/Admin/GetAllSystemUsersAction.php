<?php

namespace App\Actions\Admin;

use App\Models\Usuario;

class GetAllSystemUsersAction{

    public function execute($orderBy, $orderDirection){
        return Usuario::where('rol', 'user')->orderBy($orderBy, $orderDirection)->get();
    }

}