<?php

namespace App\Controller;

use App\Entity\Task;
use App\Interfaces\TaskRepository;
use App\Interfaces\UserLoggedInController;
use App\Interfaces\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/addTask", name="add")
     */
    public function addTask(Request $request)
    {
        $user = $this->userRepository->findOneBy(['id' => $request->getSession()->get('user_id')]);
        $taskRequest = $request->request->get('task');

        if (!empty($taskRequest) && is_string($taskRequest)) {
            $task = new Task($taskRequest, $user);

            $this->taskRepository->addTask($task);
        }

        return new JsonResponse(['task' => $task->getTask()]);
    }
}
