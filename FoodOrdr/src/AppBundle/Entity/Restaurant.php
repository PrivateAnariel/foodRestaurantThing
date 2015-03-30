<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Restaurant
 *
 * @ORM\Table(name="RESTAURANT", uniqueConstraints={@ORM\UniqueConstraint(name="ID_RESTAURANT", columns={"ID_RESTAURANT"})}, indexes={@ORM\Index(name="FK_ID_ENTREPRENEUR", columns={"ID_ENTREPRENEUR"})})
 * @ORM\Entity
 */
class Restaurant
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_RESTAURANT", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRestaurant;

      /**
     * @var integer
     *
     *  @ORM\ManyToOne(targetEntity="Restaurateur", inversedBy="restaurants")
     *  @ORM\JoinColumn(name="ID_RESTAURATEUR", referencedColumnName="ID_RESTAURATEUR")
     */
    private $idRestaurateur;

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
     * @var string
     *
     * @ORM\Column(name="ADRESSE", type="string", length=50, nullable=false)
     */
    private $adresse;

        /**
     * @var \Menu
     *
     * @ORM\ManyToOne(targetEntity="Menu")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_MENU", referencedColumnName="ID_MENU")
     * })
     */
    private $idMenu;

    /**
     * @var \Entrepreneur
     *
     * @ORM\ManyToOne(targetEntity="Entrepreneur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_ENTREPRENEUR", referencedColumnName="ID_ENTREPRENEUR")
     * })
     */
    private $idEntrepreneur;

     /**
     * @ORM\OneToMany(targetEntity="Commande", mappedBy="idRestaurant", cascade={"all"})
     **/
    private $commandes;

     public function __construct() {
        $this->commandes = new ArrayCollection();
    }

        /**
     * Get Commandes
     *
     * @return collection
     */
    public function getCommandes()
    {
        return $this->commandes;
    }

    /**
     * Set Commandes
     *
     * @return Restaurant
     */
    public function setCommandes($commandes)
    {
        foreach($commandes as $commande) {
            $commande->setIdRestaurant($this);
        }
        $this->commandes = $commandes;

        return $this;
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
     * Set adresse
     *
     * @param string $adresse
     * @return Restaurant
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
     * Set idRestaurateur
     *
     * @param \AppBundle\Entity\Restaurateur $idRestaurateur
     * @return Restaurant
     */
    public function setIdRestaurateur(\AppBundle\Entity\Restaurateur $idRestaurateur = null)
    {
        $this->idRestaurateur = $idRestaurateur;

        return $this;
    }

    /**
     * Get idRestaurateur
     *
     * @return \AppBundle\Entity\Restaurateur 
     */
    public function getIdRestaurateur()
    {
        return $this->idRestaurateur;
    }


    /**
     * Override toString() method to return the name of the restaurant
     * @return string name
     */
    public function __toString()
    {
        return $this->nom;
    }

        /**
     * Set idMenu
     *
     * @param \AppBundle\Entity\Menu $idMenu
     * @return Menu
     */
    public function setIdMenu(\AppBundle\Entity\Menu $idMenu = null)
    {
        $this->idMenu = $idMenu;

        return $this;
    }

    /**
     * Get idMenu
     *
     * @return \AppBundle\Entity\Menu
     */
    public function getIdMenu()
    {
        return $this->idMenu;
    }
}
