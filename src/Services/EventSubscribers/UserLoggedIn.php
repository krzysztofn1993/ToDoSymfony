<?php

namespace App\Services\EventSubscribers;

use App\Interfaces\UserLoggedInController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class UserLoggedIn implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->getRequest()->getSession()->has('username')) {
            $response = new Response('Sorry, you have to login to see this content', 401);

            $event->setResponse($response);
        }
    }
}
