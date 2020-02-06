<?php

namespace App\Controller;

use App\Entity\Task;
use App\Interfaces\TaskRepository;
use App\Interfaces\UserLoggedInController;
use App\Interfaces\UserRepository;
use App\Services\Helpers\PaginationHelper;
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
        $requestedPage = $request->query->get('page');
        $userId = $request->getSession()->get('user_id');
        $page = $requestedPage >= 0 && is_numeric($requestedPage)
            ? (int) $requestedPage
            : 0;
        $tasksCount = (int) ($this->taskRepository->findByAndCount([
            'user' => $userId,
            'deletionDate' => null
        ]));

        $pagesToDisplay = PaginationHelper::pagesToDisplay($tasksCount, 10);

        $tasks = $this->taskRepository->findBy(
            [
                'user' => $userId,
                'deletionDate' => null,
            ],
            null,
            10,
            $page * 10
        );

        if ($page > 0 && empty($tasks)) {
            return $this->redirectToRoute('tasks');
        }

        return $this->render(
            'tasks/index.html.twig',
            [
                'tasks' => $tasks,
                'page' => $page,
                'pagesToDisplay' => $pagesToDisplay
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

    /**
     * @Route("/tasks-history", name="history")
     */
    public function tasksHistory(Request $request)
    {
        $requestedPage = $request->query->get('page');
        $userId = $request->getSession()->get('user_id');
        $page = $requestedPage >= 0 && is_numeric($requestedPage)
            ? (int) $requestedPage
            : 0;
        $tasksCount = (int) ($this->taskRepository->findByAndCount([
            'user' => $userId
        ]));

        $pagesToDisplay = PaginationHelper::pagesToDisplay($tasksCount, 10);

        $tasks = $this->taskRepository->findBy(
            [
                'user' => $userId,
                'deletionDate' => null,
            ],
            null,
            10,
            $page * 10
        );

        return $this->render(
            'history/index.html.twig',
            [
                'tasks' => $tasks,
                'page' => $page,
                'pagesToDisplay' => $pagesToDisplay
            ]
        );
    }
}
