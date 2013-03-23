<?php

namespace Pwc\UserBundle\Listener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

use Symfony\Component\Security\Core\SecurityContext,
    Symfony\Bundle\FrameworkBundle\Routing\Router,
    Symfony\Component\HttpFoundation\Session\Session,
    Symfony\Component\Security\Http\Event\InteractiveLoginEvent,
    Symfony\Bundle\FrameworkBundle\Translation\Translator;

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

    protected $translator;

    public function __construct(Router $router, SecurityContext $security_context, Session $session, Translator $translator)
    {
        $this->router 		    = $router;
        $this->security_context = $security_context;
        $this->session 		    = $session;
        $this->translator       = $translator;
    }

    public function onCheckExpired(GetResponseEvent $event)
    {
        if ($this->security_context->getToken() && $this->security_context->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            if($event->getRequest()->get('_route') != 'fos_user_change_password' && $event->getRequest()->get('_route') != 'fos_user_security_logout')
            {
                $user = $this->security_context->getToken()->getUser();

                if($user->isPasswordExpired())
                {
                    $this->session->setFlash('error', $this->translator->trans('flash.password_expired', array(), 'PwcUserBundle'));
                    $event->setResponse(new RedirectResponse($this->router->generate('fos_user_change_password')));
                }
            }
        }
    }

    public function onCheckForcedRenewal(GetResponseEvent $event)
    {
        if ($this->security_context->getToken() && $this->security_context->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            if($event->getRequest()->get('_route') != 'fos_user_change_password' && $event->getRequest()->get('_route') != 'fos_user_security_logout')
            {
                $user = $this->security_context->getToken()->getUser();

                if($user->isForcedToRenewPassword())
                {
                    $this->session->setFlash('error', $this->translator->trans('flash.forced_renewal', array(), 'PwcUserBundle'));
                    $event->setResponse(new RedirectResponse($this->router->generate('fos_user_change_password')));
                }
            }
        }
    }

    public function onCheckPendingRenewal(InteractiveLoginEvent $event)
    {
        if ($this->security_context->getToken() && $this->security_context->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            $user = $this->security_context->getToken()->getUser();
            if($user->getDaysUntilPasswordChange() <= 7) $this->session->setFlash('info', $this->translator->transchoice('flash.about_to_expire', $user->getDaysUntilPasswordChange(), array('%count%' => $user->getDaysUntilPasswordChange()), 'PwcUserBundle'));
        }
    }
}