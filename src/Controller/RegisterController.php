<?php

namespace App\Controller;

use App\Entity\User;
use App\Forms\CredentialsForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/rejestracja", name="register")
     */
    public function index (Request $request)
    {
        $user = new User();

        $form = $this->createForm(CredentialsForm::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            echo 'sub&&valid';
        }

        return $this->render('register/index.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}
