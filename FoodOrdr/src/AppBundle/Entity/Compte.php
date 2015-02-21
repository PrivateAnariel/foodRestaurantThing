<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Compte
 *
 * @ORM\Table(name="COMPTE", uniqueConstraints={@ORM\UniqueConstraint(name="ID_COMPTE", columns={"ID_COMPTE"})}, indexes={@ORM\Index(name="FK_ID_EMPLOYE", columns={"ID_CLIENT"})})
 * @ORM\Entity
 */
class Compte
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_COMPTE", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCompte;

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
     * Get idCompte
     *
     * @return integer 
     */
    public function getIdCompte()
    {
        return $this->idCompte;
    }

    /**
     * Set idClient
     *
     * @param \AppBundle\Entity\Client $idClient
     * @return Compte
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
