<?php

namespace Pwc\SirBundle\Service;

use Pwc\SirBundle\Service\Modification;

class EntityVersion
{
    protected $modifications = array();

    protected $loggedAt;

    protected $action;

    protected $objectClass;

    protected $version;

    protected $username;

    public function __construct(\Gedmo\Loggable\Entity\LogEntry $logEntry, \Pwc\SirBundle\Service\HistoryContextProvider $historyContextProvider)
    {
        $this->loggedAt = $logEntry->getLoggedAt();
        $this->action = $logEntry->getAction();
        $this->objectClass = $logEntry->getObjectClass();
        $this->version = $logEntry->getVersion();
        $this->username = $logEntry->getUsername();

        $reversedMapping = $historyContextProvider->getReversedEntityMapping();
        $context = $historyContextProvider->getContext();

        foreach ($logEntry->getData() as $subject => $value)
        {
//            echo 'Object Class: ' . $this->objectClass . ', Subject: ' . $subject . ', Value ID: ' . $value['id'] . '<br/>';
//            var_dump($value);
//            var_dump($context[$reversedMapping[$this->objectClass]]);
            $this->modifications[] = new Modification($subject, array_key_exists($subject, $context[$reversedMapping[$this->objectClass]]) && isset($context[$reversedMapping[$this->objectClass]][$subject][$value['id']]) ? $context[$reversedMapping[$this->objectClass]][$subject][$value['id']] : $value);
        }

    }

    public function getModifications()
    {
        return $this->modifications;
    }

}