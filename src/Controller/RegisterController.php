<?php

namespace App\Controller;

use App\Entity\User;
use App\Forms\CredentialsForm;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    private $userRepository;

    /**
     * Class constructor.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/registration", name="register")
     */
    public function index(Request $request)
    {
        $user = new User();

        $form = $this->createForm(CredentialsForm::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($request->get('password'));
            $user->setUsername($request->get('username'));

            var_dump($this->userRepository->findOneBy($user->getUsername()));

            if (!$this->userRepository->getUserByName($user->getUsername())) {
                echo $user->getUsername();
                return $this->render('register/index.html.twig', [
                    'form' => $form->createView(),
                ]);
            }


            return $this->redirectToRoute('home', ['info' => 'User created'], 301);
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
