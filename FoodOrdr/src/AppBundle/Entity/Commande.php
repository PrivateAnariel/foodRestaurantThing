<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Commande
 *
 * @ORM\Table(name="COMMANDE", uniqueConstraints={@ORM\UniqueConstraint(name="ID_COMMANDE", columns={"ID_COMMANDE"})}, indexes={@ORM\Index(name="FK_ID_STATUT", columns={"ID_STATUT"}), @ORM\Index(name="FK_ID_ADRESSE", columns={"ID_ADRESSE"}), @ORM\Index(name="FK_ID_RESTAURANT", columns={"ID_RESTAURANT"}), @ORM\Index(name="FK_ID_LIVREUR", columns={"ID_LIVREUR"}), @ORM\Index(name="FK_ID_CLIENT", columns={"ID_CLIENT"})})
 * @ORM\Entity
 */
class Commande
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_COMMANDE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommande;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_LIVRAISON", type="date", nullable=false)
     */
    private $dateLivraison;

    /**
     * @var \Statut
     *
     * @ORM\ManyToOne(targetEntity="Statut")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_STATUT", referencedColumnName="ID_STATUT")
     * })
     */
    private $idStatut;

    /**
     * @var \Adresse
     *
     * @ORM\ManyToOne(targetEntity="Adresse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_ADRESSE", referencedColumnName="ID_ADRESSE")
     * })
     */
    private $idAdresse;

    /**
     * @var \Restaurant
     *
     * @ORM\ManyToOne(targetEntity="Restaurant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_RESTAURANT", referencedColumnName="ID_RESTAURANT")
     * })
     */
    private $idRestaurant;

    /**
     * @var \Livreur
     *
     * @ORM\ManyToOne(targetEntity="Livreur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_LIVREUR", referencedColumnName="ID_LIVREUR")
     * })
     */
    private $idLivreur;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CLIENT", referencedColumnName="ID_CLIENT")
     * })
     */
    private $idClient;

      /**
     * @ORM\OneToMany(targetEntity="LigneCommande", mappedBy="commande", cascade={"all"})
     **/
    public $lignecommandes;



    public function __construct() {
        $this->lignecommandes = new ArrayCollection();
    }


    /**
     * Get idCommande
     *
     * @return integer 
     */
    public function getIdCommande()
    {
        return $this->idCommande;
    }

    /**
     * Set dateLivraison
     *
     * @param \DateTime $dateLivraison
     * @return Commande
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
     * Set idStatut
     *
     * @param \AppBundle\Entity\Statut $idStatut
     * @return Commande
     */
    public function setIdStatut(\AppBundle\Entity\Statut $idStatut = null)
    {
        $this->idStatut = $idStatut;

        return $this;
    }

    /**
     * Get idStatut
     *
     * @return \AppBundle\Entity\Statut 
     */
    public function getIdStatut()
    {
        return $this->idStatut;
    }

    /**
     * Set idAdresse
     *
     * @param \AppBundle\Entity\Adresse $idAdresse
     * @return Commande
     */
    public function setIdAdresse(\AppBundle\Entity\Adresse $idAdresse = null)
    {
        $this->idAdresse = $idAdresse;

        return $this;
    }

    /**
     * Get idAdresse
     *
     * @return \AppBundle\Entity\Adresse 
     */
    public function getIdAdresse()
    {
        return $this->idAdresse;
    }

    /**
     * Set idRestaurant
     *
     * @param \AppBundle\Entity\Restaurant $idRestaurant
     * @return Commande
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

    /**
     * Set idLivreur
     *
     * @param \AppBundle\Entity\Livreur $idLivreur
     * @return Commande
     */
    public function setIdLivreur(\AppBundle\Entity\Livreur $idLivreur = null)
    {
        $this->idLivreur = $idLivreur;

        return $this;
    }

    /**
     * Get idLivreur
     *
     * @return \AppBundle\Entity\Livreur 
     */
    public function getIdLivreur()
    {
        return $this->idLivreur;
    }

    /**
     * Set idClient
     *
     * @param \AppBundle\Entity\Client $idClient
     * @return Commande
     */
    public function setIdClient(\AppBundle\Entity\Client $idClient = null)
    {
        $this->idClient = $idClient;

        return $this;
    }

    /**
     * Get idClient
     *
     * @return \AppBundle\Entity\Client 
     */
    public function getIdClient()
    {
        return $this->idClient;
    }

}
