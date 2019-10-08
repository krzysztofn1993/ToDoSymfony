<?php

namespace App\Controller;

use App\Entity\User;
use App\Forms\CredentialsForm;
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

        $form = $this->createForm(CredentialsForm::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            echo 'sub&&valid';
            // if ($this->checkCredentials->execute($user)) {

            //     echo 'good';
            // }


            // return $this->render('login/index.html.twig', [
            //     'form' => $form->createView(),
            //     'wrongCredential' => true
            // ]);
        }

        return $this->render('login/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
