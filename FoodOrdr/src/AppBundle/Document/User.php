<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @MongoDB\Document(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @MongoDB\id
     */
    protected $id;
	
	/**
     * @MongoDB\Field(type="string") $username
	 * @Assert\NotBlank()
	 * @MongoDB\UniqueIndex
     */
    protected $username;
	
	/**
     * @MongoDB\Field(type="string") $password
	 * @Assert\NotBlank()
     */
    protected $password;
	
    /**
     * @MongoDB\Field(type="string") $firstName
	 * @Assert\NotBlank()
     */
    protected $firstName;

    /**
     * @MongoDB\Field(type="string") $lastName
	 * @Assert\NotBlank()
     */
    protected $lastName;

    /**
     * @MongoDB\Field(type="date") $birthday
	 * @Assert\NotBlank()
     */
    protected $birthday;

    /**
     * @MongoDB\Field(type="string") $telephone
	 * @Assert\NotBlank()
     */
    protected $telephone;

    /**
     * @MongoDB\Field(type="string") $address
	 * @Assert\NotBlank()
     */
    protected $address;

    /**
     *  @MongoDB\ReferenceOne(targetDocument="UserAccount", inversedBy="user")
     */
    protected $account;


        /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return self
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string $firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return self
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string $lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set birthday
     *
     * @param date $birthday
     * @return self
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
        return $this;
    }

    /**
     * Get birthday
     *
     * @return date $birthday
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return self
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * Get telephone
     *
     * @return string $telephone
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Get address
     *
     * @return string $address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set account
     *
     * @param AppBundle\Document\UserAccount $account
     * @return self
     */
    public function setAccount(\AppBundle\Document\UserAccount $account)
    {
        $this->account = $account;
        return $this;
    }

    /**
     * Get account
     *
     * @return AppBundle\Document\UserAccount $account
     */
    public function getAccount()
    {
        return $this->account;
    }
	
	    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
        ) = unserialize($serialized);
    }
}
