<?php

namespace App\Controller;

use App\Entity\Task;
use App\Interfaces\TaskRepository;
use App\Interfaces\UserLoggedInController;
use App\Interfaces\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TasksController extends AbstractController implements UserLoggedInController
{
    private $taskRepository;
    private $userRepository;

    public function __construct(TaskRepository $taskRepository, UserRepository $userRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/tasks", name="tasks")
     */
    public function index(Request $request)
    {
        $tasks = $this->taskRepository->findBy([
            'user' => $request->getSession()->get('user_id'),
            'deletionDate' => null,
        ]);

        return $this->render(
            'tasks/index.html.twig',
            [
                'tasks' => $tasks
            ]
        );
    }

    /**
     * @Route("/addTask", name="addTask")
     */
    public function addTask(Request $request)
    {
        $user = $this->userRepository->findOneBy(['id' => $request->getSession()->get('user_id')]);
        $taskRequest = $request->request->get('task');

        if (!empty($taskRequest) && is_string($taskRequest)) {
            $task = new Task($taskRequest, $user);

            $this->taskRepository->addTask($task);

            return new JsonResponse([
                'task' => $task->getTask(),
                'id' => $task->getId(),
            ], Response::HTTP_OK);
        }

        return new JsonResponse(['error' => 'The task has illegal characters.'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/removeTask", name="removeTask")
     */
    public function removeTask(Request $request)
    {
        $userId = $request->getSession()->get('user_id');
        $taskToDelete = $this->taskRepository->findOneBy([
            'id' => $request->request->get('id'),
            'user' => $userId
        ]);

        if (!empty($taskToDelete)) {
            $taskToDelete->markAsDeleted();

            $this->taskRepository->removeTask($taskToDelete);

            return new JsonResponse(['id' => $taskToDelete->getId()], Response::HTTP_OK);
        }

        return new JsonResponse(['error' => 'Could not find task for this user.', Response::HTTP_BAD_REQUEST]);
    }
}
