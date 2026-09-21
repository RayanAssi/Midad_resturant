<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class EmployeeUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        $credentials['role'] = 'employee';

        return parent::retrieveByCredentials($credentials);
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        if ($user->role !== 'employee') {
            return false;
        }

        return parent::validateCredentials($user, $credentials);
    }
}