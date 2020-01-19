<?php

namespace App\Controller;

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
        $task = $request->request->get('task');
    }
}
