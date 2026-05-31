<?php

namespace App\Actions\Admin;

use App\Models\Usuario;

class GetAllSystemUsersAction{

    public function execute(){

        return Usuario::get();
    }

}