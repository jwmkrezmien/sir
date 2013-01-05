<?php

namespace Pwc\SirBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface;

use Pwc\SirBundle\Entity\RootCause;

class LoadRootCauseData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->container->getParameter('rootcauses') as $confRootcause)
        {
                $rootcause = new RootCause();
                $rootcause->setName('rootcause.' . $confRootcause);

                $manager->persist($rootcause);
        }

        $manager->flush();
    }
}