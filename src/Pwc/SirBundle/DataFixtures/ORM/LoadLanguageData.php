<?php

namespace Pwc\SirBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface;

use Pwc\SirBundle\Entity\Language;

class LoadLanguageData implements FixtureInterface, ContainerAwareInterface
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
        foreach ($this->container->getParameter('languages') as $slug => $confLanguage)
        {
                $language = new Language();
                $language->setName('language.' . $confLanguage);
                $language->setSlug($slug);

                $manager->persist($language);
        }

        $manager->flush();
    }
}