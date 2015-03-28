<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


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
     * @ORM\Column(name="ID_MENU", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMenu;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM", type="string", length=25, nullable=false)
     */
    private $nom;

     /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="menu", cascade={"all"}, cascade={"persist"})
     **/
    private $items;



    public function __construct() {
        $this->items = new ArrayCollection();
    }

    /**
     * Get Items
     *
     * @return collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set Items
     *
     * @return Menu
     */
    public function setItems($items)
    {
        foreach($items as $item) {
            $item->setMenu($this);
        }
        $this->items = $items;

        return $this;
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
     * Set nom
     *
     * @param string $nom
     * @return Menu
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
     * add Item
     *
     * @param \AppBundle\Entity\Item $item
     * @return Menu
     * 
     */
    public function addItem(\AppBundle\Entity\Item $item)
    {
        $item->setMenu($this);
        $this->items->add($item);
        return $this;
    }

      /**
     * Get id
     *
     * @return \AppBundle\Entity\Menu
     */
    public function getId()
    {
        return $this->idMenu;
    }
       /**
     * Get idMenu
     *
     * @return int id
     */
    public function idMenu()
    {
        return $this->idMenu;
    }
}
