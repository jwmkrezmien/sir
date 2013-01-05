<?php

namespace Pwc\SirBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="vulndescription")
 */
class VulnDescription
{
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
     */
    protected $language;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\Column(type="text")
     */
    protected $risk;

    /**
     * @ORM\Column(type="text")
     */
    protected $solution;

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
}