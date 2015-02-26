<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Restaurant
 *
 * @ORM\Table(name="RESTAURANT", uniqueConstraints={@ORM\UniqueConstraint(name="ID_RESTAURANT", columns={"ID_RESTAURANT"})}, indexes={@ORM\Index(name="FK_ID_ENTREPRENEUR", columns={"ID_ENTREPRENEUR"})})
 * @ORM\Entity
 */
class Restaurant
{
    /**
     * @var string
     *
     * @ORM\Column(name="NOM", type="string", length=25, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="TELEPHONE", type="string", length=25, nullable=false)
     */
    private $telephone;

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_RESTAURANT", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRestaurant;

    /**
     * @var \AppBundle\Entity\Entrepreneur
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Entrepreneur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_ENTREPRENEUR", referencedColumnName="ID_ENTREPRENEUR")
     * })
     */
    private $idEntrepreneur;



    /**
     * Set nom
     *
     * @param string $nom
     * @return Restaurant
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return Restaurant
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Get idRestaurant
     *
     * @return integer 
     */
    public function getIdRestaurant()
    {
        return $this->idRestaurant;
    }

    /**
     * Set idEntrepreneur
     *
     * @param \AppBundle\Entity\Entrepreneur $idEntrepreneur
     * @return Restaurant
     */
    public function setIdEntrepreneur(\AppBundle\Entity\Entrepreneur $idEntrepreneur = null)
    {
        $this->idEntrepreneur = $idEntrepreneur;

        return $this;
    }

    /**
     * Get idEntrepreneur
     *
     * @return \AppBundle\Entity\Entrepreneur 
     */
    public function getIdEntrepreneur()
    {
        return $this->idEntrepreneur;
    }

       /**
     * Override toString() method to return the name of the restaurant
     * @return string name
     */
    public function __toString()
    {
        return $this->nom;
    }
}
