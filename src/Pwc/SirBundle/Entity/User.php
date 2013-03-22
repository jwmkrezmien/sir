<?php

namespace Pwc\SirBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sir_user")
 */
class User extends \FOS\UserBundle\Entity\User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $lastName;

    /**
     * @ORM\Column(name="password_changed_at", type="datetime")
     */
    protected $password_changed_at;

    public function __construct()
    {
        parent::__construct();

        if(!$this->getPasswordChangedAt()) $this->setPasswordChangedAt(new \DateTime());
    }

    /**
     * Set password_changed_at
     *
     * @param \DateTime $date
     * @return User
     */
    public function setPasswordChangedAt(\DateTime $date)
    {
        $this->password_changed_at = $date;

        return $this;
    }

    /**
     * Get password_changed_at
     *
     * @return \DateTime
     */
    public function getPasswordChangedAt()
    {
        return $this->password_changed_at;
    }

    public function setPlainPassword($password)
    {
        $this->setPasswordChangedAt(new \DateTime());
        parent::setPlainPassword($password);

        return $this;
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
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }
}