<?php

namespace Pwc\SirBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="vulnref")
 */
class VulnRef
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $hyperlink;

    /**
     * @ORM\ManyToOne(targetEntity="Vulnerability", inversedBy="vulnRefs"))
     * @ORM\JoinColumn(name="vulnerability_id", referencedColumnName="id", nullable=false)
     */
    protected $vulnerability;

    public function __toString()
    {
        return $this->getName();
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
     * Set name
     *
     * @param string $name
     * @return Vulnref
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set hyperlink
     *
     * @param string $hyperlink
     * @return Vulnref
     */
    public function setHyperlink($hyperlink)
    {
        $this->hyperlink = $hyperlink;
    
        return $this;
    }

    /**
     * Get hyperlink
     *
     * @return string 
     */
    public function getHyperlink()
    {
        return $this->hyperlink;
    }

    /**
     * Set vulnerability
     *
     * @param \Pwc\SirBundle\Entity\Vulnerability $vulnerability
     * @return VulnRef
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