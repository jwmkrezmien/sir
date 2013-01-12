<?php

namespace Pwc\SirBundle\Service;

use Doctrine\ORM\EntityManager;

class ModContextProvider
{
    protected $entityManager;

    protected $entityMapping;

    protected $reversedEntityMapping = array();

    private $context = array();

    public $childObjects = array();

    public function __construct(EntityManager $entityManager, array $entityMapping = array())
    {
        $this->entityMapping = $entityMapping;
        $this->entityManager = $entityManager;

        foreach($entityMapping['entities'] as $entityFriendlyName => $entityConfig)
        {
            foreach($entityConfig['attributes'] as $attribute => $type)
            {
                foreach($this->getForeignObjects($type) as $foreignObject)
                {
                    $this->context[$entityFriendlyName][$attribute][$foreignObject->getId()] = (string) $foreignObject;
                }

                $this->reversedEntityMapping[$type] = $attribute;
            }

            $this->reversedEntityMapping[$entityConfig['namespace']] = $entityFriendlyName;
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

    public function getHierarchies()
    {
        return $this->entityMapping['hierarchies'];
    }

    public function getChildren($parent)
    {
        return (array_key_exists($parent, $this->entityMapping['hierarchies']) ? $this->entityMapping['hierarchies'][$parent] : false);
    }

    public function getEntityNamespace($entity)
    {
        return (array_key_exists($entity, $this->entityMapping['entities']) ? $this->entityMapping['entities'][$entity]['namespace'] : false);
    }

    public function addChildObject($name, array $childObjects)
    {
        foreach($childObjects as $childObject)
        {
            $this->childObjects[$name][$childObject->getId()] = $childObject;
        }
    }

    public function getChildObject($name, $id)
    {
        return (array_key_exists($name, $this->childObjects) && array_key_exists($id, $this->childObjects[$name]) ? $this->childObjects[$name][$id] : false);
    }
}