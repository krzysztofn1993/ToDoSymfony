<?php

namespace App\Services\EventSubscribers;

use App\Interfaces\UserLoggedInController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class UserLoggedIn implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController()[0];

        if ($controller instanceof UserLoggedInController && !$event->getRequest()->getSession()->has('user_id')) {
            $session = $event->getRequest()->getSession();
            // $session->getFlashBag()->add('warning', 'You have to be logged in.');
            $event->setController(function () {
                return new RedirectResponse('/');
            });
        }
    }
}
