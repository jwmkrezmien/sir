<?php

namespace Pwc\SirBundle\Service;

use Doctrine\ORM\EntityManager;

class HistoryContextProvider
{
    protected $entityManager;

    protected $entityMapping;

    protected $reversedEntityMapping = array();

    private $context = array();

    public function __construct(EntityManager $entityManager, array $entityMapping = array())
    {
        $this->entityMapping = $entityMapping;
        $this->entityManager = $entityManager;

        foreach($entityMapping as $entityFriendlyName => $entityConfig)
        {
            foreach($entityConfig['attributes'] as $attribute => $type)
            {
                foreach($this->getForeignObjects($type) as $foreignObject)
                {
                    $this->context[$entityFriendlyName][$attribute][$foreignObject->getId()] = (string) $foreignObject;
                }

                $this->reversedEntityMapping[$type] = $attribute;
            }

            $this->reversedEntityMapping[$entityConfig['entity']] = $entityFriendlyName;
        }
    }

    private function getForeignObjects($entity)
    {
        return $this->entityManager->getRepository($entity)->findAll();
    }

    public function getContext()
    {
        return $this->context;
    }

    public function getEntityMapping()
    {
        return $this->entityMapping;
    }

    public function getReversedEntityMapping()
    {
        return $this->reversedEntityMapping;
    }
}