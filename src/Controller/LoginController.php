<?php

namespace App\Controller;

use App\Entity\User;
use App\Forms\LoginForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/index", name="home")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(LoginForm::class, new User());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            var_dump('test');
        }

        return $this->render('login/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
