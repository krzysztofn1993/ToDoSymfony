<?php

namespace App\Interfaces;

interface TaskRepository
{
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
}
