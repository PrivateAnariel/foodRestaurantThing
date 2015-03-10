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
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_LIVRAISON", type="date", nullable=false)
     */
    private $dateLivraison;

    /**
     * @var string
     *
     * @ORM\Column(name="ADRESSE", type="string", length=50, nullable=true)
     */
    private $adresse;

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
     * Set dateLivraison
     *
     * @param \DateTime $dateLivraison
     * @return Menu
     */
    public function setDateLivraison($dateLivraison)
    {
        $this->dateLivraison = $dateLivraison;

        return $this;
    }

    /**
     * Get dateLivraison
     *
     * @return \DateTime 
     */
    public function getDateLivraison()
    {
        return $this->dateLivraison;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Menu
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

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
