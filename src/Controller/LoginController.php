<?php

namespace App\Controller;

use App\Entity\User;
use App\Forms\LoginForm;
use App\Services\User\UserLoginService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    private $userLoginService;

    public function __construct(UserLoginService $userLoginService)
    {
        $this->userLoginService = $userLoginService;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {
        $user = new User();
        $session = $request->getSession();

        $form = $this->createForm(LoginForm::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($request->request->get('login_form')['password']);
            $user->setUsername($request->request->get('login_form')['username']);

            if ($this->userLoginService->execute($user)) {
                $session->set('user_id', $this->userLoginService->getLoggedUser()->getId());

                return $this->redirectToRoute('tasks', [], 301);
            } else {
                $formError = new FormError('Invalid username or password.');
                $form->addError($formError);
            }
        }

        return $this->render('login/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
