<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adresse
 *
 * @ORM\Table(name="ADRESSE", indexes={@ORM\Index(name="FK_ID_CLIENT", columns={"ID_CLIENT"})})
 * @ORM\Entity
 */
class Adresse
{
    /**
     * @var integer
     *
     * @ORM\Column(name="NUMERO", type="integer", nullable=false)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="RUE", type="string", length=25, nullable=false)
     */
    private $rue;

    /**
     * @var string
     *
     * @ORM\Column(name="VILLE", type="string", length=15, nullable=false)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="CODE_POSTAL", type="string", length=10, nullable=false)
     */
    private $codePostal;

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_ADRESSE", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAdresse;

    /**
     * @var \AppBundle\Entity\Client
     *
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="adresses")
     * @ORM\JoinColumn(name="ID_CLIENT", referencedColumnName="ID_CLIENT")
     **/
    private $client;

    /**
     * Set numero
     *
     * @param integer $numero
     * @return Adresse
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set rue
     *
     * @param string $rue
     * @return Adresse
     */
    public function setRue($rue)
    {
        $this->rue = $rue;

        return $this;
    }

    /**
     * Get rue
     *
     * @return string 
     */
    public function getRue()
    {
        return $this->rue;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Adresse
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     * @return Adresse
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string 
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Get idAdresse
     *
     * @return integer 
     */
    public function getIdAdresse()
    {
        return $this->idAdresse;
    }

    /**
     * Set client
     *
     * @param \AppBundle\Entity\Client $client
     * @return Adresse
     */
    public function setClient(\AppBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \AppBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }
}
