<?php

namespace App\Interfaces;

use App\Entity\User as EntityUser;

interface User
{
    public function getUserByName(string $name): ?EntityUser;
    public function create(EntityUser $user): void;
}
