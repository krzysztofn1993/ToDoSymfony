<?php

namespace App\Services\User;

use App\Entity\User;
use App\Repository\UserRepository;

class UserLoginService
{
    /** @var UserRepository $userRepository */
    private $userRepository;
    private $loggedUser;

    /**
     * Constructor
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Check if user exist in db
     *
     * @param User $user
     * @return boolean
     */
    public function execute(User $user): bool
    {
        $userToCheckAgainst = $this->userRepository->getUserByName($user->getUsername());

        if (isset($userToCheckAgainst)) {


            return $this->checkPassword($user, $userToCheckAgainst);
        }

        return false;
    }

    /**
     * Checks password against each other for loging in user and found
     * user entity in db
     *
     * @param User $user
     * @param User $userToCheckAgainst
     * @return boolean
     */
    public function checkPassword(User $user, User $userToCheckAgainst): bool
    {
        if (password_verify($user->getPassword(), $userToCheckAgainst->getPassword())) {
            $this->loggedUser = $userToCheckAgainst;

            return true;
        }

        return false;
    }

    public function getLoggedUser(): ?User
    {
        return $this->loggedUser ?? null;
    }
}
