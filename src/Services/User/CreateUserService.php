<?php

namespace App\Services\User;

use App\Entity\User;
use App\Repository\UserRepository;

class CreateUserService
{
    /** @var UserRepository $userRepository */
    private $userRepository;

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
     * Creates User in db
     *
     * @param User $user
     * @return void
     */
    public function execute(User $user): void
    {
        $this->userRepository->create($user);
    }
}
