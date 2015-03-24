<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LigneCommande
 *
 * @ORM\Table(name="LIGNE_COMMANDE", uniqueConstraints={@ORM\UniqueConstraint(name="ID_LIGNE_COMMANDE", columns={"ID_LIGNE_COMMANDE"})}, indexes={@ORM\Index(name="FK_ID_COMMANDE", columns={"ID_COMMANDE"}), @ORM\Index(name="FK_ID_ITEM", columns={"ID_ITEM"})})
 * @ORM\Entity
 */
class LigneCommande
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_LIGNE_COMMANDE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLigneCommande;

    /**
     * @var integer
     *
     * @ORM\Column(name="QUANTITE", type="integer", nullable=false)
     */
    private $quantite;

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
     * @var \Item
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_ITEM", referencedColumnName="ID_ITEM")
     * })
     */
    private $idItem;



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

    /**
     * Set idItem
     *
     * @param \AppBundle\Entity\Item $idItem
     * @return LigneCommande
     */
    public function setIdItem(\AppBundle\Entity\Item $idItem = null)
    {
        $this->idItem = $idItem;

        return $this;
    }

    /**
     * Get idItem
     *
     * @return \AppBundle\Entity\Item 
     */
    public function getIdItem()
    {
        return $this->idItem;
    }
}
