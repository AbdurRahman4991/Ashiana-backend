<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getById($id)
    {
        return User::find($id);
    }

    public function updateUser($id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }
}