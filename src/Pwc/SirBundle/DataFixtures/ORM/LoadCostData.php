<?php

namespace Pwc\SirBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface;

use Pwc\SirBundle\Entity\Cost;

class LoadCostData implements FixtureInterface, ContainerAwareInterface
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
        if ($this->container->hasParameter('costs'))
        {
            foreach ($this->container->getParameter('costs') as $confCost)
            {
                $name = $confCost['name'];
                $rank = $confCost['rank'];

                $cost = new Cost();
                $cost->setName('cost.' . $name);
                $cost->setRank($rank);

                $manager->persist($cost);
            }

            $manager->flush();
        }
    }
}