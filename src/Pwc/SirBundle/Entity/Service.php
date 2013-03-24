<?php

namespace Pwc\SirBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="service")
 * @Gedmo\Loggable
 */
class Service
{
    protected $entityType = 'Service';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vulnerability", inversedBy="services")
     * @ORM\JoinColumn(name="vulnerability_id", referencedColumnName="id")
     */
    protected $vulnerability;

    /**
     * @ORM\Column(type="string", length=10)
     * @Gedmo\Versioned
     * @Assert\NotBlank()
     */
    protected $protocol;

    /**
     * @ORM\Column(type="integer", length=5)
     * @Gedmo\Versioned
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = "1",
     *      max = "65535",
     *      minMessage = "Ports must be between 1 and 65535",
     *      maxMessage = "Ports must be between 1 and 65535"
     * )
     */
    protected $port;

    /**
     * @Gedmo\Slug(fields={"protocol", "port"})
     * @ORM\Column(length=40)
     */
    protected $slug;

    public function __toString()
    {
        return $this->getProtocol();
    }

    /**
     * Get entity type
     *
     * @return string
     */
    public function getEntityType()
    {
        return $this->entityType;
    }

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

    /**
     * Set slug
     *
     * @param string $slug
     * @return VulnDescription
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}