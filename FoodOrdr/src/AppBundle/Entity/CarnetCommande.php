<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CarnetCommande
 *
 * @ORM\Table(name="CARNET_COMMANDE", uniqueConstraints={@ORM\UniqueConstraint(name="ID_CARNET_COMMANDE", columns={"ID_CARNET_COMMANDE"})}, indexes={@ORM\Index(name="FK_ID_COMMANDE", columns={"ID_COMMANDE"}), @ORM\Index(name="FK_ID_LIVREUR", columns={"ID_LIVREUR"})})
 * @ORM\Entity
 */
class CarnetCommande
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_CARNET_COMMANDE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCarnetCommande;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_ACCEPTEE", type="date", nullable=false)
     */
    private $dateAcceptee;

    /**
     * @var \Commande
     *
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_COMMANDE", referencedColumnName="ID_COMMANDE")
     * })
     */
    private $idCommande;

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
     * Get idCarnetCommande
     *
     * @return integer 
     */
    public function getIdCarnetCommande()
    {
        return $this->idCarnetCommande;
    }

    /**
     * Set dateAcceptee
     *
     * @param \DateTime $dateAcceptee
     * @return CarnetCommande
     */
    public function setDateAcceptee($dateAcceptee)
    {
        $this->dateAcceptee = $dateAcceptee;

        return $this;
    }

    /**
     * Get dateAcceptee
     *
     * @return \DateTime 
     */
    public function getDateAcceptee()
    {
        return $this->dateAcceptee;
    }

    /**
     * Set idCommande
     *
     * @param \AppBundle\Entity\Commande $idCommande
     * @return CarnetCommande
     */
    public function setIdCommande(\AppBundle\Entity\Commande $idCommande = null)
    {
        $this->idCommande = $idCommande;

        return $this;
    }

    /**
     * Get idCommande
     *
     * @return \AppBundle\Entity\Commande 
     */
    public function getIdCommande()
    {
        return $this->idCommande;
    }

    /**
     * Set idLivreur
     *
     * @param \AppBundle\Entity\Livreur $idLivreur
     * @return CarnetCommande
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
}
