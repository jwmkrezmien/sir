<?php

namespace Pwc\SirBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface;

use Pwc\SirBundle\Entity\Impact;

class LoadImpactData implements FixtureInterface, ContainerAwareInterface
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
        if ($this->container->hasParameter('impacts'))
        {
            foreach ($this->container->getParameter('impacts') as $confImpact)
            {
                $name = $confImpact['name'];
                $rank = $confImpact['rank'];

                $impact = new Impact();
                $impact->setName('impact.' . $name);
                $impact->setRank($rank);

                $manager->persist($impact);
            }

            $manager->flush();
        }
    }
}