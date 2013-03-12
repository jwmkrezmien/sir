<?php

namespace Pwc\SirBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

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
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128)
     */
    protected $slug;

    protected $available = false;

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

    /**
     * Set slug
     *
     * @param string $slug
     * @return Language
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

    /**
     * Set availability of language for new description
     *
     * @param boolean $available
     * @return Language
     */
    public function setAvailable($available)
    {
        $this->available = is_bool($available) ? $available : true;

        return $this;
    }

    /**
     * Get availability of language for new description
     *
     * @return boolean
     */
    public function getAvailable()
    {
        return $this->available;
    }
}