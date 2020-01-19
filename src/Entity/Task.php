<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $task_description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tasks")
     * @ORM\JoinColumn(name="task_user_id", referencedColumnName="id")
     */
    private $task_user_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaskDescription(): ?string
    {
        return $this->task_description;
    }

    public function setTaskDescription(string $task_description): self
    {
        $this->task_description = $task_description;

        return $this;
    }

    public function getTaskUserId(): ?User
    {
        return $this->task_user_id;
    }

    public function setTaskUserId(?User $task_user): self
    {
        $this->task_user_id = $task_user;

        return $this;
    }
}
