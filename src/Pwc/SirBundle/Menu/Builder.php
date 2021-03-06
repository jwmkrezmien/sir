<?php

namespace Pwc\SirBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav nav-pills');

        $user = $this->container->get('security.context')->getToken()->getUser();

        if($user->isRestricted())
        {
/*
            $menu->addChild('Home', array('route' => '_homepage'))
                 ->setAttribute('icon', 'icon-home');
            $menu->addChild('Reports', array('route' => '_homepage'))
                 ->setAttribute('icon', 'icon-book');
*/
            $menu->addChild('Vulnerabilities', array('route' => 'vulnerability'))
                 ->setAttribute('icon', 'icon-bolt');
            $menu->addChild('Settings', array('route' => 'settings'))
                 ->setAttribute('icon', 'icon-cogs');
        }

        return $menu;
    }

    public function userMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');

        $user = $this->container->get('security.context')->getToken()->getUser();

        $menu->addChild('User', array('label' => $user->getFirstname() && $user->getLastname() ? $user->getFirstname() . ' ' . $user->getLastname() : $user->getUsername()))
             ->setAttribute('dropdown', true)
             ->setAttribute('icon', 'icon-user');

        if($user->isRestricted())
        {
            $menu['User']->addChild('Profile settings', array('route' => 'fos_user_profile_show'))
                         ->setAttribute('icon', 'icon-edit');

            $menu['User']->addChild('Change Password', array('route' => 'fos_user_change_password'))
                         ->setAttribute('icon', 'icon-key')
                         ->setAttribute('divider_append', true);
        }

        $menu['User']->addChild('Logout', array('route' => 'fos_user_security_logout'))
                     ->setAttribute('icon', 'icon-signout');

        return $menu;
    }

    public function settingsMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav nav-stacked nav-pills');

        $menu->addChild('Product management', array('route' => 'product'));
        $menu->addChild('Tool management', array('route' => 'tool'));
        $menu->addChild('OWASP list management', array('route' => 'owaspset'));

        return $menu;
    }

    public function accountMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav nav-stacked nav-pills');

        $user = $this->container->get('security.context')->getToken()->getUser();

        if($user->isRestricted()) $menu->addChild('Profile settings', array('route' => 'fos_user_profile_show'));
        $menu->addChild('Change password', array('route' => 'fos_user_change_password'));

        return $menu;
    }

    public function actionsMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'dropdown-menu');

        $menu->addChild('Edit', array('route' => 'product'))
             ->setAttribute('icon', 'icon-pencil');
        $menu->addChild('Delete', array('route' => 'product'))
             ->setAttribute('icon', 'icon-trash');

        return $menu;
    }
}