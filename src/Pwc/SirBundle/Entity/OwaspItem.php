<?php

namespace Pwc\SirBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Pwc\SirBundle\Repository\OwaspItemRepository")
 * @ORM\Table(name="owaspitem")
 */
class OwaspItem
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="OwaspSet", inversedBy="owaspItems")
     * @ORM\JoinColumn(name="owaspset_id", referencedColumnName="id")
     */
    protected $owaspset;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="integer", length=2)
     */
    protected $rank;

    /**
     * @ORM\OneToMany(targetEntity="OwaspRef", mappedBy="vulnerability")
     */
    protected $owaspRefs;

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
     * @return OwaspItem
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
     * Set owaspset
     *
     * @param \Pwc\SirBundle\Entity\OwaspSet $owaspset
     * @return OwaspItem
     */
    public function setOwaspset(\Pwc\SirBundle\Entity\OwaspSet $owaspset = null)
    {
        $this->owaspset = $owaspset;
    
        return $this;
    }

    /**
     * Get owaspset
     *
     * @return \Pwc\SirBundle\Entity\OwaspSet 
     */
    public function getOwaspset()
    {
        return $this->owaspset;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     * @return OwaspItem
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    
        return $this;
    }

    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Add owaspRefs
     *
     * @param \Pwc\SirBundle\Entity\OwaspRef $owaspRef
     * @return Vulnerability
     */
    public function addOwaspRef(\Pwc\SirBundle\Entity\OwaspRef $owaspRef)
    {
        $this->owaspRefs[] = $owaspRef;

        return $this;
    }

    /**
     * Remove owaspRefs
     *
     * @param \Pwc\SirBundle\Entity\OwaspRef $owaspRef
     */
    public function removeOwaspRef(\Pwc\SirBundle\Entity\OwaspRef $owaspRef)
    {
        $this->owaspRefs->removeElement($owaspRef);
    }

    /**
     * Get owaspRefs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOwaspRefs()
    {
        return $this->owaspRefs;
    }
}