<?php

namespace Pwc\SirBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="time")
 */
class Time
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
     * @ORM\Column(type="integer", length=1)
     */
    protected $rank;

    /**
     * @ORM\OneToMany(targetEntity="Vulnerability", mappedBy="time")
     */
    protected $vulnerabilities;

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->vulnerabilities = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Time
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
     * Set rank
     *
     * @param integer $rank
     * @return Time
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    
        return $this;
    }

    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Add vulnerability
     *
     * @param \Pwc\SirBundle\Entity\Vulnerability $vulnerability
     * @return Time
     */
    public function addVulnerability(\Pwc\SirBundle\Entity\Vulnerability $vulnerability)
    {
        $this->vulnerabilities[] = $vulnerability;
    
        return $this;
    }

    /**
     * Remove vulnerability
     *
     * @param \Pwc\SirBundle\Entity\Vulnerability $vulnerability
     */
    public function removeVulnerability(\Pwc\SirBundle\Entity\Vulnerability $vulnerability)
    {
        $this->vulnerabilities->removeElement($vulnerability);
    }

    /**
     * Get vulnerabilities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVulnerabilities()
    {
        return $this->vulnerabilities;
    }
}