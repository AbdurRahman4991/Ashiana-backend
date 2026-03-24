<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function getProfile($userId)
    {
        return $this->userRepo->getById($userId);
    }

    public function updateProfile($userId, array $data)
    {
        // if (isset($data['password'])) {
        //     $data['password'] = Hash::make($data['password']);
        // }
        return $this->userRepo->updateUser($userId, $data);
    }
}