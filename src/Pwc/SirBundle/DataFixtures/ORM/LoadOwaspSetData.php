<?php

namespace Pwc\SirBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface;

use Pwc\SirBundle\Entity\OwaspSet,
    Pwc\SirBundle\Entity\OwaspItem;

class LoadOwaspSetData implements FixtureInterface, ContainerAwareInterface
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
        foreach ($this->container->getParameter('owaspsets') as $year => $owaspset)
        {
            $name = $owaspset["name"];
            $owaspitems = $owaspset["items"];

                $owaspset = new OwaspSet();
                $owaspset->setName($name);
                $owaspset->setYear($year);

                foreach($owaspitems as $rank => $confOwaspItem)
                {
                    $owaspitem = new OwaspItem();
                    $owaspitem->setName('owaspitem.' . $confOwaspItem);
                    $owaspitem->setOwaspset($owaspset);
                    $owaspitem->setRank($rank);
                    $manager->persist($owaspitem);
                }

                $manager->persist($owaspset);
        }

        $manager->flush();
    }
}