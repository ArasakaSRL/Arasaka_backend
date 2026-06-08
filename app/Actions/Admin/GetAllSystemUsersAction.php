<?php

namespace App\Actions\Admin;

use App\Models\Usuario;

class GetAllSystemUsersAction{

    public function execute($orderBy, $orderDirection){
        return Usuario::orderBy($orderBy, $orderDirection)->get();
    }

}