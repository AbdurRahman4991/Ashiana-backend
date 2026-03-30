<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    public function updatePassword($id, string $newPassword)
    {
        $user = User::findOrFail($id);
        $user->password = Hash::make($newPassword);
        $user->save();
        return $user;
    }
}