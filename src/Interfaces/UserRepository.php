<?php

namespace App\Interfaces;

use App\Entity\User;

interface UserRepository
{
    public function create(User $user): void;
    public function findOneBy(array $criteria, array $orderBy = null);
}
