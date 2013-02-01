<?php

namespace Pwc\SirBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="Tool", inversedBy="products")
     * @ORM\JoinTable(name="product_tools")
     **/
    private $tools;

    /**
     * @ORM\OneToMany(targetEntity="Vulnerability", mappedBy="product")
     */
    protected $vulnerabilities;

    public function __construct()
    {
        $this->tools = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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
     * @return Product
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
     * Add tool
     *
     * @param \Pwc\SirBundle\Entity\Tool $tool
     * @return Product
     */
    public function addTool(\Pwc\SirBundle\Entity\Tool $tool)
    {
        $this->tools[] = $tool;
    
        return $this;
    }

    /**
     * Remove tool
     *
     * @param \Pwc\SirBundle\Entity\Tool $tool
     */
    public function removeTool(\Pwc\SirBundle\Entity\Tool $tool)
    {
        $this->tools->removeElement($tool);
    }

    /**
     * Get tools
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTools()
    {
        return $this->tools;
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