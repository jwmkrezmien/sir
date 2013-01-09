<?php

namespace Pwc\SirBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface;

use Pwc\SirBundle\Entity\Time;

class LoadTimeData implements FixtureInterface, ContainerAwareInterface
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
        if ($this->container->hasParameter('times'))
        {
            foreach ($this->container->getParameter('times') as $confTime)
            {
                $name = $confTime['name'];
                $rank = $confTime['rank'];

                $time = new Time();
                $time->setName('time.' . $name);
                $time->setRank($rank);

                $manager->persist($time);
            }

            $manager->flush();
        }
    }
}