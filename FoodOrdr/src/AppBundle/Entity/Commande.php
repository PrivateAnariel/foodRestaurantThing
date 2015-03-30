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
     * @ORM\Column(name="DATE_LIVRAISON", type="datetime", nullable=false)
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
    private $adresse;

    /**
     * @var \Restaurant
     *
     * @ORM\ManyToOne(targetEntity="Restaurant", inversedBy="commandes")
     * @ORM\JoinColumn(name="ID_RESTAURANT", referencedColumnName="ID_RESTAURANT")
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
     * @ORM\OneToMany(targetEntity="LigneCommande", mappedBy="idCommande", cascade={"all"})
     **/
    private $ligneCommandes;



    public function __construct() {
        $this->ligneCommandes = new ArrayCollection();
    }

        /**
     * Get LigneCommandes
     *
     * @return collection
     */
    public function getLigneCommandes()
    {
        return $this->ligneCommandes;
    }

    /**
     * Set LigneCommandes
     *
     * @return Client
     */
    public function setLigneCommandes($ligneCommandes)
    {
        foreach($ligneCommandes as $ligneCommande) {
            $ligneCommande->setIdCommande($this);
        }
        $this->ligneCommandes = $ligneCommandes;

        return $this;
    }

    /**
     * add LigneCommande
     *
     * @param \AppBundle\Entity\LigneCommande $ligneCommande
     * @return Client
     */
    public function addLigneCommande(\AppBundle\Entity\LigneCommande $ligneCommande)
    {
        $ligneCommande->setIdCommande($this);
        $this->ligneCommandes->add($ligneCommande);
        return $this;
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
    public function setStatut(\AppBundle\Entity\Statut $idStatut = null)
    {
        $this->idStatut = $idStatut;

        return $this;
    }

    /**
     * Get idStatut
     *
     * @return \AppBundle\Entity\Statut 
     */
    public function getStatut()
    {
        return $this->idStatut;
    }

    /**
     * Set adresse
     *
     * @param \AppBundle\Entity\Adresse $adresse
     * @return Commande
     */
    public function setadresse(\AppBundle\Entity\Adresse $adresse = null)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return \AppBundle\Entity\Adresse 
     */
    public function getAdresse()
    {
        return $this->adresse;
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
    public function getRestaurant()
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
    public function getClient()
    {
        return $this->idClient;
    }

    /**
     * Get confNo
     *
     * @return computed confNo 
     */
    public function getConfNo()
    {
        return $this->idCommande."-".$this->idRestaurant->getIdRestaurant()."-".$this->dateLivraison->format('H-i')."-".$this->idClient->getIdClient();
    }
}
