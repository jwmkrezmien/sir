<?php

namespace Pwc\UserBundle\Listener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

use Symfony\Component\Security\Core\SecurityContext,
    Symfony\Bundle\FrameworkBundle\Routing\Router,
    Symfony\Component\HttpFoundation\Session\Session,
    Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

use FOS\UserBundle\Doctrine\UserManager;

/**
 * @Service("request.set_messages_count_listener")
 *
 */
class ForcePasswordUpdateListener
{
    protected $security_context;

    protected $router;

    protected $session;

    protected $userManager;

    public function __construct(Router $router, SecurityContext $security_context, Session $session)
    {
        $this->router 		    = $router;
        $this->security_context = $security_context;
        $this->session 		    = $session;
    }

    public function onCheckExpired(GetResponseEvent $event)
    {
        if ($this->security_context->getToken() && $this->security_context->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            if($event->getRequest()->get('_route') != 'fos_user_change_password' && $event->getRequest()->get('_route') != 'fos_user_security_logout')
            {
                $user = $this->security_context->getToken()->getUser();

                if($user->getPasswordChangedAt()->diff(new \DateTime())->format('%a') >= 90)
                {
                    $this->session->setFlash('error', "Your password hash expired. Please change it");
                    $event->setResponse(new RedirectResponse($this->router->generate('fos_user_change_password')));
                }
            }
        }
    }
}