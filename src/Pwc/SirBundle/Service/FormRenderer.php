<?php

namespace Pwc\SirBundle\Service;

use Symfony\Component\Form\Form;

class FormRenderer
{
    protected $forms = array();

    protected $type = false;

    protected $settings;

    protected $entity;

    public function __construct()
    {
        $this->settings['name'] = 'name';
        $this->settings['identifier'] = 'slug';
    }

    public function getEntityName()
    {
        return call_user_func($entity, 'get' . $this->settings['identifier']);
    }

    public function getEntityIdentifier()
    {
        return call_user_func($entity, 'get' . $this->settings['identifier']);
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function addForm($entity, Form $form)
    {

        $this->forms[call_user_func($entity, 'get' . $this->settings['identifier'])] = $form;
    }

    public function getForm($slug)
    {
        return (isset($this->forms[$slug]) ? $this->forms[$slug] : false);
    }
}