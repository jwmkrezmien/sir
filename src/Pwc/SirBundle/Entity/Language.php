<?php

namespace Pwc\SirBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="language")
 */
class Language
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
     * @ORM\OneToMany(targetEntity="VulnDescription", mappedBy="language")
     */
    protected $vulnDescriptions;

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
     * @return Language
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
     * Constructor
     */
    public function __construct()
    {
        $this->vulnDescriptions = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add vulnDescriptions
     *
     * @param \Pwc\SirBundle\Entity\VulnDescription $vulnDescriptions
     * @return Language
     */
    public function addVulnDescription(\Pwc\SirBundle\Entity\VulnDescription $vulnDescriptions)
    {
        $this->vulnDescriptions[] = $vulnDescriptions;
    
        return $this;
    }

    /**
     * Remove vulnDescriptions
     *
     * @param \Pwc\SirBundle\Entity\VulnDescription $vulnDescriptions
     */
    public function removeVulnDescription(\Pwc\SirBundle\Entity\VulnDescription $vulnDescriptions)
    {
        $this->vulnDescriptions->removeElement($vulnDescriptions);
    }

    /**
     * Get vulnDescriptions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVulnDescriptions()
    {
        return $this->vulnDescriptions;
    }
}