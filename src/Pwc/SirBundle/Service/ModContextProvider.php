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

    /**
     * Check whether a particular attribute of an entity has a glossary
     *
     * @param string $entity
     * @param string $attribute
     * @return bool
     */
    public function hasGlossary($entity, $attribute)
    {
        return array_key_exists($attribute, $this->glossary[$entity]) && isset($this->glossary[$entity][$attribute]) ? true : false;
    }

    /**
     * Get the glossary for a given ID in a particular entity's attribute
     *
     * @param string $entity
     * @param string $attribute
     * @param integer $id
     * @return string or bool
     */
    public function getGlossary($entity, $attribute, $id)
    {
        return isset($this->glossary[$entity][$attribute][$id]) ? $this->glossary[$entity][$attribute][$id] : false;
    }

    /**
     * Set the glossary for a particular entity
     *
     * @param string $entity
     */
    protected function setGlossary($entity)
    {
        $this->addGlossary($entity);
        foreach($this->getHierarchy($entity) as $child) $this->addGlossary($child);
    }

    /**
     * Add the glossary for a particular entity to the glossary array
     *
     * @param string $entity
     */
    protected function addGlossary($entity)
    {
        foreach($this->getEntityAttributes($entity) as $attribute => $namespace)
        {
            foreach($this->getForeignObjects($namespace) as $foreignObject)
            {
                $this->glossary[$entity][$attribute][$foreignObject->getId()] = (string) $foreignObject;
            }
        }
    }

    /**
     * Return an array of foreign objects
     *
     * @param string $entity
     * @return array
     */
    private function getForeignObjects($entity)
    {
        return $this->entityManager->getRepository($entity)->findAll();
    }

    /**
     * Set the reversed mapping for an entity
     *
     * @param string $name
     */
    protected function setReversedMapping($name)
    {
        $this->addReversedMapping($name);
        foreach($this->getHierarchy($name) as $child) $this->addReversedMapping($child);
    }

    /**
     * Add the reversed mapping for a particular entity to the reversed mapping array
     *
     * @param string $name
     */
    protected function addReversedMapping($name)
    {
        $this->reversedEntityMapping[$this->getEntityNamespace($name)] = $name;
        foreach($this->getEntityAttributes($name) as $attribute => $namespace) $this->reversedEntityMapping[$namespace] = $attribute;
    }

    /**
     * Return reversed entity mapping for namespace
     *
     * @param string $namespace
     * @return string
     */
    public function getReversedEntityMapping($namespace)
    {
        return array_key_exists($namespace, $this->reversedEntityMapping) ? $this->reversedEntityMapping[$namespace] : false;
    }

    /**
     * Add current versions of objects to the current versions array
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
     * Set current versions of objects
     *
     * @param string $name
     * @param array $entity
     */
    public function setCurrentVersions($name, $entity)
    {
        $this->addCurrentVersions($name, array($entity));

        foreach($this->getHierarchy($name) as $currentVersion)
        {
            $this->addCurrentVersions(
                $currentVersion,
                call_user_func(array($this->entityManager->getRepository($this->getEntityNamespace($currentVersion)), 'findBy' . $name), $entity)
            );
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