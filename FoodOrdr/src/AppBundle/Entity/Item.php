<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Item
 *
 * @ORM\Table(name="ITEM", uniqueConstraints={@ORM\UniqueConstraint(name="ID_ITEM", columns={"ID_ITEM"})}, indexes={@ORM\Index(name="FK_ID_MENU", columns={"ID_MENU"})})
 * @ORM\Entity
 */
class Item
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_ITEM", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idItem;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM", type="string", length=25, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPTION", type="string", length=100, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="PRIX", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $prix;

    /**
     * @var \Menu
     *
     * @ORM\ManyToOne(targetEntity="Menu",inversedBy="adresses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_MENU", referencedColumnName="ID_MENU")
     * })
     */
    private $menu;



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
     * Set nom
     *
     * @param string $nom
     * @return Item
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
     * Set description
     *
     * @param string $description
     * @return Item
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set prix
     *
     * @param string $prix
     * @return Item
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string 
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set idMenu
     *
     * @param \AppBundle\Entity\Menu $menu
     * @return Item
     */
    public function setMenu(\AppBundle\Entity\Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }



    /**
     * Get menu
     *
     * @return \AppBundle\Entity\Menu 
     */
    public function getMenu()
    {
        return $this->menu;
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
