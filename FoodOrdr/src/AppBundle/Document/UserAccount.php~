<?php
namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="AppBundle\Repository\UserAccountRepository")
 */
class UserAccount
{
    /**
     * @MongoDB\id
     */
    protected $id;
	
	 /**
     *  @MongoDB\ReferenceOne(targetDocument="User", mappedBy="account")
     */
    protected $user;


    /**
     * Set id
     *
     * @param id $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
     * Set user
     *
     * @param AppBundle\Document\User $user
     * @return self
     */
    public function setUser(\AppBundle\Document\User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return AppBundle\Document\User $user
     */
    public function getUser()
    {
        return $this->user;
    }
}
