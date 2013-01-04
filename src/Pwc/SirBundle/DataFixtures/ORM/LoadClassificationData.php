<?php

namespace Pwc\SirBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface;

use Pwc\SirBundle\Entity\Classification;

class LoadClassificationData implements FixtureInterface, ContainerAwareInterface
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
        foreach ($this->container->getParameter('classifications') as $type => $classes)
        {
            foreach ($classes as $rank => $class)
            {
                $classification = new Classification();
                $classification->setName('classification.' . $type . '.' . $class);
                $classification->setType($type);
                $classification->setClass($class);
                $classification->setRank($rank);

                $manager->persist($classification);
            }
        }

        $manager->flush();
    }
}