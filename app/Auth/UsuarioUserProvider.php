<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Hashing\Hasher;

class UsuarioUserProvider extends EloquentUserProvider
{
    public function __construct(Hasher $hasher, $model)
    {
        parent::__construct($hasher, $model);
    }

    public function retrieveByCredentials(array $credentials)
    {
        if (isset($credentials['email'])) {
            $credentials['correo'] = $credentials['email'];
            unset($credentials['email']);
        }

        return parent::retrieveByCredentials($credentials);
    }
}
