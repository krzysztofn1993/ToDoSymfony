<?php

namespace App\Interfaces;

use App\Entity\Task;

interface TaskRepository
{
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
    public function findOneBy(array $criteria, array $orderBy = null);
    public function addTask(Task $task): void;
    public function removeTask(Task $task): void;
}
