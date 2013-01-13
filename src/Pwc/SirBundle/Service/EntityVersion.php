<?php

namespace Pwc\SirBundle\Service;

use Pwc\SirBundle\Service\Modification;

class EntityVersion
{
    protected $modifications = array();

    protected $loggedAt;

    protected $action;

    protected $objectClass;

    protected $objectId;

    protected $version;

    protected $username;

    protected $modContextProvider;

    public function __construct(\Gedmo\Loggable\Entity\LogEntry $logEntry, \Pwc\SirBundle\Service\ModContextProvider $modContextProvider)
    {
        $this->loggedAt = $logEntry->getLoggedAt();
        $this->action = $logEntry->getAction();
        $this->objectClass = $logEntry->getObjectClass();
        $this->objectId = $logEntry->getObjectId();
        $this->version = $logEntry->getVersion();
        $this->username = $logEntry->getUsername();
        $this->modContextProvider = $modContextProvider;

        //$context = $this->modContextProvider->getGlossary2();

        foreach ($logEntry->getData() as $attribute => $value)
        {
            $this->modifications[] = new Modification(
                                            $attribute,
                                            $this->modContextProvider->hasGlossary(
                                                $this->modContextProvider->getReversedEntityMapping($this->objectClass),
                                                $attribute
                                            ) ? $this->modContextProvider->getGlossary(
                                                $this->modContextProvider->getReversedEntityMapping($this->objectClass),
                                                $attribute,
                                                $value['id']
                                            ) : $value
                                     );
        }
/*
        foreach ($logEntry->getData() as $subject => $value)
        {
            $this->modifications[] = new Modification($subject, array_key_exists($subject, $context[$this->getObjectName()]) && isset($context[$this->getObjectName()][$subject][$value['id']]) ? $context[$this->getObjectName()][$subject][$value['id']] : $value);
        }
*/
    }

    /**
     * Get modifications set in the version update of this entity
     *
     * @return array
     */
    public function getModifications()
    {
        return $this->modifications;
    }

    /**
     * Get a datetime object for the moment this entity version was set
     *
     * @return \DateTime
     */
    public function getLoggedAt()
    {
        return $this->loggedAt;
    }

    /**
     * Get the action that was performed [create, update or delete]
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Get the namespace of the class
     *
     * @return string
     */
    public function getObjectClass()
    {
        return $this->objectClass;
    }

    /**
     * Get the ID of the altered object
     *
     * @return integer
     */
    public function getObjectId()
    {
        return $this->objectId;
    }

    /**
     * Get the version number
     *
     * @return integer
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get the username of the one who made the alteration
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->version;
    }

    /**
     * Get the name of the object
     *
     * @return string
     */
    public function getObjectName()
    {
        return $this->modContextProvider->getReversedEntityMapping($this->objectClass);
    }

    /**
     * Get converted form label
     *
     * @param string $subject
     * @return string
     */
    public function convertSubjectToLabel($subject)
    {
        return 'form.label.'. $this->getObjectName() . '.' . $subject;
    }

    /**
     * Get the current version of the entity
     *
     * @return object
     */
    public function getCurrent()
    {
        return $this->modContextProvider->getCurrentObject($this->getObjectName(), $this->getObjectId());
    }

    /**
     * Get the attribute that uniquely identifies this entity
     *
     * @return string
     */
    protected function getIdentifierAttribute()
    {
        return $this->modContextProvider->getEntityIdentifier($this->getObjectName()) ? $this->modContextProvider->getEntityIdentifier($this->getObjectName()) : 'id';
    }

    protected function getCurrentAttributeValue($attribute)
    {
        return call_user_func(array($this->modContextProvider->getCurrentObject($this->getObjectName(), $this->getObjectId()), 'get' . $attribute));
    }

    public function getIdentifierOfCurrent()
    {
        return $this->getCurrentAttributeValue($this->getIdentifierAttribute());
    }
}