<?php

namespace Pwc\SirBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="service")
 */
class Service
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="_Vulnerability", inversedBy="services")
     * @ORM\JoinColumn(name="vulnerability_id", referencedColumnName="id")
     */
    protected $vulnerability;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $protocol;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $port;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set protocol
     *
     * @param string $protocol
     * @return Service
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;
    
        return $this;
    }

    /**
     * Get protocol
     *
     * @return string 
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * Set port
     *
     * @param string $port
     * @return Service
     */
    public function setPort($port)
    {
        $this->port = $port;
    
        return $this;
    }

    /**
     * Get port
     *
     * @return string 
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set vulnerability
     *
     * @param \Pwc\SirBundle\Entity\Vulnerability $vulnerability
     * @return Service
     */
    public function setVulnerability(\Pwc\SirBundle\Entity\Vulnerability $vulnerability = null)
    {
        $this->vulnerability = $vulnerability;
    
        return $this;
    }

    /**
     * Get vulnerability
     *
     * @return \Pwc\SirBundle\Entity\Vulnerability 
     */
    public function getVulnerability()
    {
        return $this->vulnerability;
    }
}