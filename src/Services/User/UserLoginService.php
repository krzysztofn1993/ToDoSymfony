<?php

namespace App\Services\User;

use App\Entity\User;
use App\Repository\UserRepository;

class UserLoginService
{
    private $userRepository;

    public function __constructor(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(User $user): bool
    {
        $userToCheckAgainst = $this->userRepository->getUser($user->getUsername);

        if (isset($userToCheckAgainst)) {

            return $this->checkPassword($user, $userToCheckAgainst);
        }

        return false;
    }

    public function checkPassword(User $user, User $userToCheckAgainst): bool
    {
        return $user->getPassword() === $userToCheckAgainst->getPassword();
    }
}
