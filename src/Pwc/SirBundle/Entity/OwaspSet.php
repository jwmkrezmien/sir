<?php

namespace Pwc\SirBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="owaspset")
 */
class OwaspSet
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
     * @ORM\Column(type="integer", length=4)
     */
    protected $year;

    /**
     * @ORM\OneToMany(targetEntity="OwaspItem", mappedBy="owaspset")
     */
    protected $owaspItems;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128)
     */
    protected $slug;

    public function __toString()
    {
        return $this->getName();
    }

    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return OwaspSet
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
     * Add owaspItems
     *
     * @param \Pwc\SirBundle\Entity\OwaspItem $owaspItems
     * @return OwaspSet
     */
    public function addOwaspItem(\Pwc\SirBundle\Entity\OwaspItem $owaspItem)
    {
        $this->owaspItems[] = $owaspItem;
    
        return $this;
    }

    /**
     * Remove owaspItems
     *
     * @param \Pwc\SirBundle\Entity\OwaspItem $owaspItems
     */
    public function removeOwaspItem(\Pwc\SirBundle\Entity\OwaspItem $owaspItem)
    {
        $this->owaspItems->removeElement($owaspItem);
    }

    /**
     * Get owaspItems
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOwaspItems()
    {
        return $this->owaspItems;
    }

    /**
     * Set year
     *
     * @param integer $year
     * @return OwaspSet
     */
    public function setYear($year)
    {
        $this->year = $year;
    
        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Product
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