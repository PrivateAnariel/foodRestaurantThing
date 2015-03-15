<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="COMMANDE", uniqueConstraints={@ORM\UniqueConstraint(name="ID_COMMANDE", columns={"ID_COMMANDE"})}, indexes={@ORM\Index(name="FK_ID_ADRESSE", columns={"ID_ADRESSE"}), @ORM\Index(name="FK_ID_RESTAURANT", columns={"ID_RESTAURANT"}), @ORM\Index(name="FK_ID_LIVREUR", columns={"ID_LIVREUR"}), @ORM\Index(name="FK_ID_CLIENT", columns={"ID_CLIENT"})})
 * @ORM\Entity
 */
class Commande
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
     * @ORM\Column(name="STATUT", type="string", length=10, nullable=false)
     */
    private $statut;

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_COMMANDE", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommande;

    /**
     * @var \AppBundle\Entity\Client
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CLIENT", referencedColumnName="ID_CLIENT")
     * })
     */
    private $idClient;

    /**
     * @var \AppBundle\Entity\Livreur
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Livreur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_LIVREUR", referencedColumnName="ID_LIVREUR")
     * })
     */
    private $idLivreur;

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
     * @var \AppBundle\Entity\Adresse
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adresse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_ADRESSE", referencedColumnName="ID_ADRESSE")
     * })
     */
    private $idAdresse;



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
     * Set statut
     *
     * @param string $statut
     * @return Commande
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string 
     */
    public function getStatut()
    {
        return $this->statut;
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
}
