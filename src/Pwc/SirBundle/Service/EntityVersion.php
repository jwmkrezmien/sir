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

        $reversedMapping = $this->modContextProvider->getReversedEntityMapping();
        $context = $this->modContextProvider->getContext();

        foreach ($logEntry->getData() as $subject => $value)
        {
            $this->modifications[] = new Modification($subject, array_key_exists($subject, $context[$this->getObjectName()]) && isset($context[$this->getObjectName()][$subject][$value['id']]) ? $context[$this->getObjectName()][$subject][$value['id']] : $value);
        }

    }

    public function getModifications()
    {
        return $this->modifications;
    }

    public function getLoggedAt()
    {
        return $this->loggedAt;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getObjectClass()
    {
        return $this->objectClass;
    }

    public function getObjectId()
    {
        return $this->objectId;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getUsername()
    {
        return $this->version;
    }

    public function getObjectName()
    {
        $rm = $this->modContextProvider->getReversedEntityMapping();
        return $rm[$this->objectClass];
    }

    public function convertSubjectToLabel($subject)
    {
        return 'form.label.'. $this->getObjectName() . '.' . $subject;
    }
}