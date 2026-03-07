<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{

    public function register(array $data)
    {
        $user = User::create([
            'pharmacy_name' => $data['pharmacy_name'],
            'contact_no' => $data['contact_no'],
            'name' => $data['name'],
            'address' => $data['address'],
            'roleid' => $data['roleid'],
            'role_name'=> $data['role_name'],
            'password' => Hash::make($data['password'])
        ]);

        return $user;
    }

    public function login(array $data)
    {
        if (!Auth::attempt([
            'contact_no' => $data['contact_no'],
            'password' => $data['password']
        ])) {

            return null;
        }

        return Auth::user();
    }
}