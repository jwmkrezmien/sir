<?php

namespace Pwc\SirBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="owaspref")
 * @Gedmo\Loggable
 */
class OwaspRef
{
    protected $entityType = 'OwaspRef';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vulnerability", inversedBy="owaspRefs")
     * @ORM\JoinColumn(name="vulnerability_id", referencedColumnName="id")
     */
    protected $vulnerability;

    /**
     * @ORM\ManyToOne(targetEntity="OwaspItem", inversedBy="owaspRefs")
     * @ORM\JoinColumn(name="owaspitem_id", referencedColumnName="id")
     * @Gedmo\Versioned
     */
    protected $owaspitem;

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
     * @return OwaspRef
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
     * Set owaspitem
     *
     * @param \Pwc\SirBundle\Entity\OwaspItem $owaspitem
     * @return OwaspRef
     */
    public function setOwaspitem(\Pwc\SirBundle\Entity\OwaspItem $owaspitem = null)
    {
        $this->owaspitem = $owaspitem;
    
        return $this;
    }

    /**
     * Get owaspitem
     *
     * @return \Pwc\SirBundle\Entity\OwaspItem 
     */
    public function getOwaspitem()
    {
        return $this->owaspitem;
    }
}