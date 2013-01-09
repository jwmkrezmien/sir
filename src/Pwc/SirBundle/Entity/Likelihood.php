<?php

namespace Pwc\SirBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="likelihood")
 */
class Likelihood
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
     * @ORM\Column(type="string", length=25)
     */
    protected $type;

    /**
     * @ORM\Column(type="integer", length=1)
     */
    protected $rank;

    /**
     * @ORM\OneToMany(targetEntity="Vulnerability", mappedBy="likelihood")
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
     * @return Likelihood
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
     * Set type
     *
     * @param string $type
     * @return Likelihood
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * Set rank
     *
     * @param integer $rank
     * @return Likelihood
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
     * @return Likelihood
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