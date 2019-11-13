<?php

namespace App\Controller;

use App\Entity\User;
use App\Forms\CredentialsForm;
use App\Repository\UserRepository;
use App\Services\User\CreateUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /** @var CreateUserService $createUserService */
    private $createUserService;

    /** @var UserRepository $userRepository */
    private $userRepository;

    /**
     * Class constructor
     *
     * @param CreateUserService $createUserService
     * @param UserRepository $userRepository
     */
    public function __construct(
        CreateUserService $createUserService,
        UserRepository $userRepository
    ) {
        $this->createUserService = $createUserService;
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
            $user->setPassword($request->request->get('credentials_form')['password']);
            $user->setUsername($request->request->get('credentials_form')['username']);

            if ($this->userRepository->getUserByName($user->getUsername())) {

                $formError = new FormError('User already exists! Pick other Username.');
                $form->addError($formError);

                return $this->render('register/index.html.twig', [
                    'form' => $form->createView(),
                ]);
            }

            $this->createUserService->execute($user);
            $this->addFlash('success', 'User created!');

            return $this->redirectToRoute('home', [], 301);
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
