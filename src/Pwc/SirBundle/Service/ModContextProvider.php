<?php

namespace Pwc\SirBundle\Service;

use Doctrine\ORM\EntityManager;

class ModContextProvider
{
    protected $entityManager;

    protected $entityMapping;

    protected $reversedEntityMapping = array();

    private $glossary = array();

    public $currentVersions = array();

    public function __construct(EntityManager $entityManager, array $entityMapping = array())
    {
        $this->entityMapping = $entityMapping;
        $this->entityManager = $entityManager;

        $this->setGlossary('vulnerability');
        $this->setReversedMapping('vulnerability');
    }

    public function hasGlossary($entity, $attribute)
    {
        return array_key_exists($attribute, $this->glossary[$entity]) && isset($this->glossary[$entity][$attribute]) ? true : false;
    }

    public function getGlossary($entity, $attribute, $id)
    {
        return isset($this->glossary[$entity][$attribute][$id]) ? $this->glossary[$entity][$attribute][$id] : false;
    }
/*
    public function getGlossary2()//$entity, $attribute, $id)
    {
        return $this->glossary;
    }
*/
    protected function setGlossary($name)
    {
        $this->addGlossary($name);
        foreach($this->getHierarchy($name) as $child) $this->addGlossary($child);
/*
        foreach($this->getEntities() as $entityFriendlyName => $entityConfig)
        {
            foreach($entityConfig['attributes'] as $attribute => $type)
            {
                foreach($this->getForeignObjects($type) as $foreignObject)
                {
                    $this->glossary[$entityFriendlyName][$attribute][$foreignObject->getId()] = (string) $foreignObject;
                }
            }
        }
*/
    }

    protected function addGlossary($name)
    {
        foreach($this->getEntityAttributes($name) as $attribute => $namespace)
        {
            foreach($this->getForeignObjects($namespace) as $foreignObject)
            {
                $this->glossary[$name][$attribute][$foreignObject->getId()] = (string) $foreignObject;
            }
        }
    }

    protected function setReversedMapping($name)
    {
        $this->addReversedMapping($name);
        foreach($this->getHierarchy($name) as $child) $this->addReversedMapping($child);
    }

    protected function addReversedMapping($name)
    {
        $this->reversedEntityMapping[$this->getEntityNamespace($name)] = $name;
        foreach($this->getEntityAttributes($name) as $attribute => $namespace) $this->reversedEntityMapping[$namespace] = $attribute;
    }

    public function setCurrentVersions($name, $entity)
    {
        var_dump(get_class($entity));

        var_dump($this->reversedEntityMapping);

        $this->addCurrentVersions($name, array($entity));

        foreach($this->getHierarchy($name) as $currentVersion)
        {
            $this->addCurrentVersions(
                $currentVersion,
                call_user_func(array($this->entityManager->getRepository($this->getEntityNamespace($currentVersion)), 'findBy' . $name), $entity)
            );

            //$this->addCurrentVersions($currentVersion, $em->getRepository($this->getEntityNamespace($currentVersion))->findByVulnerability($entity));
        }
    }

    /**
     * Get the complete entity mapping
     *
     * @return array
     */
    public function getEntityMapping()
    {
        return $this->entityMapping;
    }

    /**
     * Get the complete list of hierarchies
     *
     * @return array
     */
    public function getHierarchies()
    {
        return $this->entityMapping['hierarchies'];
    }

    /**
     * Get the complete list of entities
     *
     * @return array
     */
    public function getEntities()
    {
        return $this->entityMapping['entities'];
    }

    /**
     * Get a hierarchy configuration
     *
     * @param string $hierarchy
     * @return array
     */
    public function getHierarchy($hierarchy)
    {
        return array_key_exists($hierarchy, $this->entityMapping['hierarchies']) ? $this->entityMapping['hierarchies'][$hierarchy] : false;
    }

    /**
     * Get a entity configuration

     * @param string $entity
     * @return array
     */
    public function getEntity($entity)
    {
        return array_key_exists($entity, $this->entityMapping['entities']) ? $this->entityMapping['entities'][$entity] : false;
    }

    /**
     * Get a entity namespace

     * @param string $entity
     * @return string
     */
    public function getEntityNamespace($entity)
    {
        return array_key_exists($entity, $this->entityMapping['entities']) && isset($this->entityMapping['entities'][$entity]['namespace']) ? $this->entityMapping['entities'][$entity]['namespace'] : false;
    }

    /**
     * Get a entity namespace

     * @param string $entity
     * @return array
     */
    public function getEntityAttributes($entity)
    {
        return array_key_exists($entity, $this->entityMapping['entities']) && isset($this->entityMapping['entities'][$entity]['attributes']) ? $this->entityMapping['entities'][$entity]['attributes'] : false;
    }

    /**
     * Get an entity's attribute namespace

     * @param string $entity
     * @param string $attribute
     * @return string
     */
    public function getAttributeNamespace($entity, $attribute)
    {
        return array_key_exists($entity, $this->entityMapping['entities']) && isset($this->entityMapping['entities'][$entity]['attributes'][$attribute]) ? $this->entityMapping['entities'][$entity]['attributes'][$attribute] : false;
    }

    /**
     * Get a entity identifier

     * @param string $entity
     * @return string
     */
    public function getEntityIdentifier($entity)
    {
        return array_key_exists($entity, $this->entityMapping['entities']) && isset($this->entityMapping['entities'][$entity]['identifier']) ? $this->entityMapping['entities'][$entity]['identifier'] : false;
    }

    private function getForeignObjects($entity)
    {
        return $this->entityManager->getRepository($entity)->findAll();
    }

    public function getReversedEntityMapping($namespace)
    {
        return array_key_exists($namespace, $this->reversedEntityMapping) ? $this->reversedEntityMapping[$namespace] : false;
    }

    /**
     * Add current versions of objects
     *
     * @param string $name
     * @param array $currentVersions
     */
    public function addCurrentVersions($name, array $currentVersions)
    {
        foreach($currentVersions as $currentVersion)
        {
            $this->currentVersions[$name][$currentVersion->getId()] = $currentVersion;
        }
    }

    /**
     * Get current versions of objects
     *
     * @param string $name
     * @param integer $id
     * @return object
     */
    public function getCurrentObject($name, $id)
    {
        return (array_key_exists($name, $this->currentVersions) && array_key_exists($id, $this->currentVersions[$name]) ? $this->currentVersions[$name][$id] : false);
    }
}