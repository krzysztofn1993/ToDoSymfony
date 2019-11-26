<?php

namespace App\Controller;

use App\Interfaces\UserLoggedInController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TasksController extends AbstractController implements UserLoggedInController
{
    /**
     * @Route("/tasks", name="tasks")
     */
    public function index()
    {
        return $this->render('tasks/index.html.twig', [
            'controller_name' => 'TasksController',
        ]);
    }
}
