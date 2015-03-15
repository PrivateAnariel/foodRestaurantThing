<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LigneCommande
 *
 * @ORM\Table(name="LIGNE_COMMANDE", uniqueConstraints={@ORM\UniqueConstraint(name="ID_LIGNE_COMMANDE", columns={"ID_LIGNE_COMMANDE"})}, indexes={@ORM\Index(name="FK_ID_COMMANDE", columns={"ID_COMMANDE"})})
 * @ORM\Entity
 */
class LigneCommande
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_ITEM", type="integer", nullable=false)
     */
    private $idItem;

    /**
     * @var integer
     *
     * @ORM\Column(name="QUANTITE", type="integer", nullable=false)
     */
    private $quantite;

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_LIGNE_COMMANDE", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLigneCommande;

    /**
     * @var \AppBundle\Entity\Commande
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_COMMANDE", referencedColumnName="ID_COMMANDE")
     * })
     */
    private $idCommande;



    /**
     * Set idItem
     *
     * @param integer $idItem
     * @return LigneCommande
     */
    public function setIdItem($idItem)
    {
        $this->idItem = $idItem;

        return $this;
    }

    /**
     * Get idItem
     *
     * @return integer 
     */
    public function getIdItem()
    {
        return $this->idItem;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     * @return LigneCommande
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer 
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Get idLigneCommande
     *
     * @return integer 
     */
    public function getIdLigneCommande()
    {
        return $this->idLigneCommande;
    }

    /**
     * Set idCommande
     *
     * @param \AppBundle\Entity\Commande $idCommande
     * @return LigneCommande
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
}
