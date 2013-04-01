<?php

namespace Pwc\SirBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="productref")
 * @Gedmo\Loggable
 */
class ProductRef
{
    protected $entityType = 'ProductRef';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vulnerability", inversedBy="productRefs")
     * @ORM\JoinColumn(name="vulnerability_id", referencedColumnName="id")
     */
    protected $vulnerability;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productRefs")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * @Gedmo\Versioned
     */
    protected $product;

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
     * @return ProductRef
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
     * Set product
     *
     * @param \Pwc\SirBundle\Entity\Product $product
     * @return ProductRef
     */
    public function setProduct(\Pwc\SirBundle\Entity\Product $product = null)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return \Pwc\SirBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}