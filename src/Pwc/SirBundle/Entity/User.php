<?php

namespace Pwc\SirBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sir_user")
 */
class User extends \FOS\UserBundle\Entity\User
{
    protected $maxPassAge = 90;

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

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $forced_renewal;

    public function __construct()
    {
        parent::__construct();

        if(!$this->getPasswordChangedAt()) $this->setPasswordChangedAt(new \DateTime());
    }

    /**
     * Set the flag to renew the password upon the next login attempt
     *
     * @param $boolean
     * @return User
     */
    public function setForcePasswordRenewal($boolean)
    {
        $this->forced_renewal = (Boolean) $boolean;

        return $this;
    }

    /**
     * Get the flag to renew the password upon the next login attempt
     *
     * @return boolean
     */
    public function isForcedToRenewPassword()
    {
        return $this->forced_renewal;
    }

    /**
     * Get the flag to renew the password upon the next login attempt
     *
     * @return boolean
     */
    public function isPasswordExpired()
    {
        return $this->getPasswordAge() >= $this->maxPassAge ? true : false;
    }

    /**
     * Get the password age in days
     *
     * @return integer
     */
    public function getPasswordAge()
    {
        return $this->getPasswordChangedAt()->diff(new \DateTime())->format('%a');
    }

    /**
     * Get the number of days until a password change is required
     *
     * @return integer
     */
    public function getDaysUntilPasswordChange()
    {
        return $this->maxPassAge - $this->getPasswordChangedAt()->diff(new \DateTime())->format('%a');
    }

    /**
     * See whether a restricted version of the interface is needed, because the password needs to be changed
     *
     * @return boolean
     */
    public function isRestricted()
    {
        return $this->isForcedToRenewPassword() || $this->isPasswordExpired() ? false : true;
    }

    /**
     * Set the datetime object for the moment the password was changed for the last time
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
     * Get the datetime object for the moment the password was changed for the last time
     *
     * @return \DateTime
     */
    public function getPasswordChangedAt()
    {
        return $this->password_changed_at;
    }

    public function setPlainPassword($password)
    {
        // if the password was already changed before, then set the forced renewal flag to false
        // this check is initiated to separate the user initiation process from the user update process
        if (isset($this->forced_renewal))
        {
            $this->setForcePasswordRenewal(false);
        }else{
            $this->setForcePasswordRenewal(true);
        }

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