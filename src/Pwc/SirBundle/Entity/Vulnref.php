<?php

namespace Pwc\SirBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="vulnref")
 * @Gedmo\Loggable
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
     * @Gedmo\Versioned
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Versioned
     * @Assert\NotBlank()
     * @Assert\Url()
     */
    protected $hyperlink;

    /**
     * @ORM\ManyToOne(targetEntity="Vulnerability", inversedBy="vulnRefs"))
     * @ORM\JoinColumn(name="vulnerability_id", referencedColumnName="id", nullable=false)
     */
    protected $vulnerability;

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