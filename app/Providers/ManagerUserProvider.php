<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class ManagerUserProvider extends EloquentUserProvider
{
    
    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        $credentials['role'] = 'manager';

        return parent::retrieveByCredentials($credentials);
    }


    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        if ($user->role !== 'manager') {
            return false;
        }

        return parent::validateCredentials($user, $credentials);
    }
}