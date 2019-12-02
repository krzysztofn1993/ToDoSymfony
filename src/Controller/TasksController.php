<?php

namespace App\Controller;

use App\Interfaces\UserLoggedInController;
use App\Repository\TaskRepository;
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
        $session = $request->getSession();

        $tasks = $this->taskRepository->findBy(['user_id' => $session->get('user_id')]);

        return $this->render('tasks/index.html.twig', [
            'controller_name' => 'TasksController',
        ]);
    }
}
