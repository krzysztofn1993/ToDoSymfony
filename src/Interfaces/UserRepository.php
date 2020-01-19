<?php

namespace App\Interfaces;

use App\Entity\User;

interface UserRepository
{
    public function getUserByName(string $name): ?User;
    public function create(User $user): void;
}
