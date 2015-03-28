<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Statut
 *
 * @ORM\Table(name="STATUT", uniqueConstraints={@ORM\UniqueConstraint(name="ID_STATUT", columns={"ID_STATUT"})})
 * @ORM\Entity
 */
class Statut
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_STATUT", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idStatut;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPTION", type="string", length=25, nullable=false)
     */
    private $description;



    /**
     * Get idStatut
     *
     * @return integer 
     */
    public function getIdStatut()
    {
        return $this->idStatut;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Statut
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
     * Override toString() method to return the name of the statut
     * @return string description
     */
    public function __toString()
    {
        return $this->description;
    }
}
