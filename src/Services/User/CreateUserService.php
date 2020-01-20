<?php

namespace App\Services\User;

use App\Entity\User;
use App\Interfaces\UserRepository;

class CreateUserService
{
    /** @var InterfacesUser $userRepository */
    private $userRepository;

    /**
     * Constructor
     *
     * @param InterfacesUser $userRepository
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
