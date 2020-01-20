<?php

namespace App\Controller;

use App\Entity\Task;
use App\Interfaces\TaskRepository;
use App\Interfaces\UserLoggedInController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TasksController extends AbstractController implements UserLoggedInController
{
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @Route("/tasks", name="tasks")
     */
    public function index(Request $request)
    {
        $tasks = $this->taskRepository->findBy(['task_user_id' => $request->getSession()->get('user_id')]);

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
        $userId = $request->getSession()->get('user_id');
        $taskRequest = $request->request->get('task');

        if (!isEmpty($taskRequest) && is_string($taskRequest)) {
            $task = new Task($taskRequest, $userId);

            $this->taskRepository->addTask($task);
        }
    }
}
