<?php

namespace App\Controller;

use App\Entity\User;
use App\Forms\LoginForm;
use App\Services\User\CheckCredentials;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    private $checkCredentials;

    public function __constructor(CheckCredentials $checkCredentials)
    {
        $this->checkCredentials = $checkCredentials;
    }

    /**
     * @Route("/", name="home")
     */
    public function index (Request $request)
    {
        $user = new User();

        $form = $this->createForm(LoginForm::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // if ($this->checkCredentials->execute($user)) {

            //     echo 'good';
            // }


            // return $this->render('login/index.html.twig', [
            //     'form' => $form->createView(),
            //     'wrongCredential' => true
            // ]);
        }

        return $this->render('login/index.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/rejestracja", name="register")
     */
    public function register (Request $request)
    {
        $user = new User();

        $form = $this->createForm(LoginForm::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->checkCredentials->execute($user)) {

                echo 'good';
            }


            return $this->render('login/index.html.twig', [
                'form' => $form->createView(),
                'wrongCredential' => true
            ]);
        }

        return $this->render('login/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
