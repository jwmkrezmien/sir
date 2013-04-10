<?php

namespace Pwc\SirBundle\Service;

use Doctrine\ORM\EntityManager;

class EntityRemover
{
    protected $em;

    protected $config;

    protected $entity;

    protected $relations;

    public function __construct(array $config = array())
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setConfig(array $config = array())
    {
        $this->config = $config;

        return $this;
    }

    public function setEntityManager(EntityManager &$em)
    {
        $this->em = $em;

        return $this;
    }

    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    public function prepare()
    {
        $ec = $this->getEntityConfig();

        foreach ($ec['relations'] as $plural => $singular)
        {
            if (count(call_user_func(array($this->entity, 'get' . $plural))) > 0)
            {
                foreach(call_user_func(array($this->entity, 'get' . $plural)) as $item) $this->relations[$plural][] = $item;
            }else
            {
                $this->relations[$plural] = array();
            }
        }
    }

    protected function sanitize()
    {
        $ec = $this->getEntityConfig();

        foreach ($ec['relations'] as $plural => $singular)
        {
            foreach(call_user_func(array($this->entity, 'get' . $plural)) as $item)
            {
                foreach($this->relations[$plural] as $key => $obsolete)
                {
                    if ($obsolete->getId() === $item->getId()) unset($this->relations[$plural][$key]);
                }
            }
        }

        return $this;
    }

    public function process()
    {
        $ec = $this->getEntityConfig();

        $this->sanitize();

        foreach ($ec['relations'] as $plural => $singular)
        {
            foreach($this->relations[$plural] as $key => $obsolete)
            {
                if(method_exists($obsolete, 'set' . $ec['call']))
                {
                    call_user_func(array($obsolete, 'set' . $ec['call']), null);

                }elseif(isset($this->entity) && method_exists($this->entity, 'remove' . $singular))
                {
                    call_user_func(array($this->entity, 'remove' . $singular), $obsolete);
                }

                $this->em->remove($obsolete);
                unset($this->relations[$plural][$key]);
            }
        }

        return $this;
    }

    protected function getEntityConfig()
    {
        if (isset($this->entity))
        {
            $config = $this->getConfig();

            return in_array(get_class($this->entity), array_keys($config)) ? $config[get_class($this->entity)] : false;
        }else
        {
            return false;
        }
    }
}