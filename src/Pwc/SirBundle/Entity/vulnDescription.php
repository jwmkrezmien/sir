<?php

namespace Pwc\SirBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="vulndescription")
 * @Gedmo\Loggable
 */
class VulnDescription
{
    protected $entityType = 'VulnDescription';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vulnerability", inversedBy="vulnDescriptions")
     * @ORM\JoinColumn(name="vulnerability_id", referencedColumnName="id")
     */
    protected $vulnerability;

    /**
     * @ORM\ManyToOne(targetEntity="Language", inversedBy="vulnDescriptions")
     * @ORM\JoinColumn(name="language_id", referencedColumnName="id")
     * @Gedmo\Versioned
     */
    protected $language;

    /**
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @Gedmo\Versioned
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @Gedmo\Versioned
     * @ORM\Column(type="text")
     */
    protected $risk;

    /**
     * @Gedmo\Versioned
     * @ORM\Column(type="text")
     */
    protected $solution;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128)
     */
    protected $slug;

    public function __toString()
    {
        return $this->getName();
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
     * Set vulnerability
     *
     * @param \Pwc\SirBundle\Entity\Vulnerability $vulnerability
     * @return VulnDescription
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
     * Set language
     *
     * @param \Pwc\SirBundle\Entity\Language $language
     * @return VulnDescription
     */
    public function setLanguage(\Pwc\SirBundle\Entity\Language $language = null)
    {
        $this->language = $language;
    
        return $this;
    }

    /**
     * Get language
     *
     * @return \Pwc\SirBundle\Entity\Language 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return VulnDescription
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
     * Set description
     *
     * @param string $description
     * @return VulnDescription
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set risk
     *
     * @param string $risk
     * @return VulnDescription
     */
    public function setRisk($risk)
    {
        $this->risk = $risk;
    
        return $this;
    }

    /**
     * Get risk
     *
     * @return string 
     */
    public function getRisk()
    {
        return $this->risk;
    }

    /**
     * Set solution
     *
     * @param string $solution
     * @return VulnDescription
     */
    public function setSolution($solution)
    {
        $this->solution = $solution;
    
        return $this;
    }

    /**
     * Get solution
     *
     * @return string 
     */
    public function getSolution()
    {
        return $this->solution;
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