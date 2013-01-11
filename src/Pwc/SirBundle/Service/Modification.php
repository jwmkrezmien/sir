<?php

namespace Pwc\SirBundle\Service;

class Modification
{
    protected $subject;

    protected $value;

    public function __construct($subject, $value)
    {
        $this->setSubject($subject);
        $this->setValue($value);
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
}