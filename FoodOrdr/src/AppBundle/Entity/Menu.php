<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table(name="MENU", uniqueConstraints={@ORM\UniqueConstraint(name="ID_MENU", columns={"ID_MENU"})}, indexes={@ORM\Index(name="FK_ID_RESTAURANT", columns={"ID_RESTAURANT"})})
 * @ORM\Entity
 */
class Menu
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_MENU", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMenu;

    /**
     * @var \AppBundle\Entity\Restaurant
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Restaurant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_RESTAURANT", referencedColumnName="ID_RESTAURANT")
     * })
     */
    private $idRestaurant;



    /**
     * Get idMenu
     *
     * @return integer 
     */
    public function getIdMenu()
    {
        return $this->idMenu;
    }

    /**
     * Set idRestaurant
     *
     * @param \AppBundle\Entity\Restaurant $idRestaurant
     * @return Menu
     */
    public function setIdRestaurant(\AppBundle\Entity\Restaurant $idRestaurant = null)
    {
        $this->idRestaurant = $idRestaurant;

        return $this;
    }

    /**
     * Get idRestaurant
     *
     * @return \AppBundle\Entity\Restaurant 
     */
    public function getIdRestaurant()
    {
        return $this->idRestaurant;
    }
}
