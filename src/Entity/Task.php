<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Task
{
    public function __construct(string $task, User $user)
    {
        $this->task = $task;
        $this->user = $user;
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $task;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletionDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTask(): ?string
    {
        return $this->task;
    }

    public function setTask(string $task): self
    {
        $this->task = $task;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user;
    }

    public function setUserId(?User $user): self
    {
        $this->user_id = $user;

        return $this;
    }

    public function getCreationDate(): string
    {
        return $this->creationDate->format('Y-m-d H:i:s');
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreationDate(): self
    {
        if ($this->creationDate !== null) {
            return $this;
        }

        $this->creationDate = new DateTime();

        return $this;
    }

    public function getDeletionDate(): ?string
    {
        if ($this->deletionDate === null) {
            return null;
        }

        return $this->deletionDate->format('Y-m-d H:i:s');
    }

    public function markAsDeleted(): self
    {
        if ($this->deletionDate !== null) {
            return $this;
        }

        $this->deletionDate = new DateTime();

        return $this;
    }

    public function __toString()
    {
        return (string) $this->task;
    }
}
