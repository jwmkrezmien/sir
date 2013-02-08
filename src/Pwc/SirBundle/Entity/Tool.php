<?php

namespace Pwc\SirBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="tool")
 */
class Tool
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
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="tools")
     **/
    private $products;

    /**
     * @ORM\OneToMany(targetEntity="Vulnerability", mappedBy="tool")
     */
    protected $vulnerabilities;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128)
     */
    protected $slug;

    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Tool
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
     * Add product
     *
     * @param \Pwc\SirBundle\Entity\Product $product
     * @return Tool
     */
    public function addProduct(\Pwc\SirBundle\Entity\Product $product)
    {
        $this->products[] = $product;
    
        return $this;
    }

    /**
     * Remove products
     *
     * @param \Pwc\SirBundle\Entity\Product $products
     */
    public function removeProduct(\Pwc\SirBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
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