<?php

namespace Pwc\SirBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface;

use Pwc\SirBundle\Entity\Likelihood;

class LoadLikelihoodData implements FixtureInterface, ContainerAwareInterface
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
        if ($this->container->hasParameter('likelihoods'))
        {
            foreach ($this->container->getParameter('likelihoods') as $confLikelihood)
            {
                $name = $confLikelihood['name'];
                $rank = $confLikelihood['rank'];

                $likelihood = new Likelihood();
                $likelihood->setName('likelihood.' . $name);
                $likelihood->setRank($rank);

                $manager->persist($likelihood);
            }

            $manager->flush();
        }
    }
}