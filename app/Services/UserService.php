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
      
        return $this->userRepo->updateUser($userId, $data);
    }

    public function changePassword($userId, $oldPassword, $newPassword)
    {
        $user = $this->userRepo->getById($userId);
        if (!$user) {
            return ['success' => false, 'message' => 'User not found'];
        }

        if (!Hash::check($oldPassword, $user->password)) {
            return ['success' => false, 'message' => 'Old password is incorrect'];
        }

        $this->userRepo->updatePassword($userId, $newPassword);

        return ['success' => true, 'message' => 'Password updated successfully'];
    }
}