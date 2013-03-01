<?php

namespace Pwc\SirBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Settings controller.
 *
 * @Route("/settings")
 */
class SettingsController extends Controller
{
    /**
     * Lists all Product entities.
     *
     * @Route("/", name="settings")
     * @Template()
     */
    public function indexAction()
    {
        return array(
            'title'      => 'Settings'
        );
    }
}
