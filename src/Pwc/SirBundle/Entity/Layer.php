<?php

namespace Pwc\SirBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="layer")
 */
class Layer
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
     * @ORM\OneToMany(targetEntity="Vulnerability", mappedBy="layer")
     */
    protected $vulnerabilities;

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
     * @return Layer
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
     * Add vulnerabilities
     *
     * @param \Pwc\SirBundle\Entity\Vulnerability $vulnerabilities
     * @return Product
     */
    public function addVulnerability(\Pwc\SirBundle\Entity\Vulnerability $vulnerability)
    {
        $this->vulnerabilities[] = $vulnerability;

        return $this;
    }

    /**
     * Remove vulnerabilities
     *
     * @param \Pwc\SirBundle\Entity\Vulnerability $vulnerabilities
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