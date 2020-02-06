<?php

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    private $entityManager;
    private $userRepository;
    private $user;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->userRepository = $this->entityManager->getRepository(User::class);
        $this->taskRepository = $this->entityManager->getRepository(Task::class);

        $this->user = (new User())
            ->setName('userForUnitTests')
            ->setPassword('userForUnitTests');
    }

    public function testUserDoesNotExist()
    {
        $notFoundUser = $this->userRepository
            ->findOneBy([
                'name' => $this->user->getName()
            ]);

        $this->assertNull($notFoundUser);
    }

    /**
     * @depends testUserDoesNotExist
     */
    public function testUserExists()
    {
        $this->userRepository->create($this->user);

        $foundUser = $this->userRepository
            ->findOneBy([
                'name' => $this->user->getName()
            ]);

        $this->assertIsObject($foundUser);
    }

    /**
     * @depends testUserExists
     */
    public function testPasswordIsHashed()
    {
        $userForPassword = $this->userRepository
            ->findOneBy([
                'name' => $this->user->getName()
            ]);

        $this->assertTrue(
            password_verify('userForUnitTests', $userForPassword->getPassword()),
            'Password not verified correctly'
        );
    }

    /**
     * @depends testUserExists
     */
    public function testUserNotHaveTasks()
    {
        $user = $this->userRepository->findOneBy(['name' => $this->user->getName()]);
        $taskNotFound = $this->taskRepository->findOneBy(['user' => $user->getId()]);

        $this->assertNull($taskNotFound);
    }

    /**
     * @depends testUserExists
     */
    public function testUserHaveTask()
    {
        $user = $this->userRepository->findOneBy(['name' => $this->user->getName()]);

        $task = new Task('task for unit tests', $user);

        $this->taskRepository->addTask($task);

        $taskFound = $this->taskRepository->findOneBy(['user' => $user->getId()]);

        $this->assertIsObject($taskFound);
    }

    /**
     * @depends testUserHaveTask
     */
    public function testTaskIsDeletedLogically()
    {
        $user = $this->userRepository->findOneBy(['name' => $this->user->getName()]);
        $taskToDeleteLogically = $this->taskRepository->findOneBy(['user' => $user->getId()]);
        $taskToDeleteLogically->markAsDeleted();

        $this->taskRepository->removeTask($taskToDeleteLogically);

        $taskDeletedLogically = $this->taskRepository->findOneBy([
            'user' => $user->getId()
        ]);

        $this->assertNotNull($taskDeletedLogically->getDeletionDate());
    }

    /**
     * @depends testTaskIsDeletedLogically
     */
    public function testUserTaskIsErasedFromDatabase()
    {
        $user = $this->userRepository->findOneBy(['name' => $this->user->getName()]);
        $taskToErase = $this->taskRepository->findOneBy(['user' => $user->getId()]);

        $this->taskRepository->eraseTask($taskToErase);

        $taskNotFound = $this->taskRepository->findOneBy([
            'user' => $user->getId()
        ]);

        $this->assertNull($taskNotFound);
    }

    /**
     * @depends testPasswordIsHashed
     */
    public function testUserIsDeleted()
    {
        $userToRemove = $this->userRepository
            ->findOneBy([
                'name' => $this->user->getName()
            ]);

        $this->userRepository->remove($userToRemove);

        $notFoundUser = $this->userRepository
            ->findOneBy([
                'name' => $this->user->getName()
            ]);

        $this->assertNull($notFoundUser);
    }


    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
        $this->userRepository = null;
    }
}
