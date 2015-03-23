<?php

namespace AppBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Client
 *
 * @ORM\Table(name="CLIENT", uniqueConstraints={@ORM\UniqueConstraint(name="COURRIEL", columns={"COURRIEL"}), @ORM\UniqueConstraint(name="ID_CLIENT", columns={"ID_CLIENT"})})
 * @ORM\Entity
 */
class Client implements UserInterface, \Serializable
{
    /**
     * @var string
     *
     * @ORM\Column(name="NOM", type="string", length=25, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="PRENOM", type="string", length=25, nullable=false)
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATENAISSANCE", type="date", nullable=false)
     */
    private $datenaissance;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="TELEPHONE", type="string", length=25, nullable=false)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="COURRIEL", type="string", length=75, nullable=false)
     */
    private $courriel;

    /**
     * @var string
     *
     * @ORM\Column(name="MDP", type="string", length=100, nullable=false)
     */
    private $mdp;

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_CLIENT", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idClient;

    /**
     * @ORM\OneToMany(targetEntity="Adresse", mappedBy="client", cascade={"all"})
     **/
    private $adresses;

      /**
     * @var \AppBundle\Entity\Adresse
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adresse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_ADRESSE_MAIN", referencedColumnName="ID_ADRESSE")
     * })
     */
    private $idAdresseMain;


    public function __construct() {
        $this->adresses = new ArrayCollection();
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Client
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
     * Set prenom
     *
     * @param string $prenom
     * @return Client
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set datenaissance
     *
     * @param \DateTime $datenaissance
     * @return Client
     */
    public function setDatenaissance(\DateTime $datenaissance)
    {
        $this->datenaissance = $datenaissance;

        return $this;
    }

    /**
     * Get datenaissance
     *
     * @return \DateTime 
     */
    public function getDatenaissance()
    {
        return $this->datenaissance;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return Client
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set courriel
     *
     * @param string $courriel
     * @return Client
     */
    public function setCourriel($courriel)
    {
        $this->courriel = $courriel;

        return $this;
    }

    /**
     * Get courriel
     *
     * @return string 
     */
    public function getCourriel()
    {
        return $this->courriel;
    }

    /**
     * Set mdp
     *
     * @param string $mdp
     * @return Client
     */
    public function setMdp($mdp)
    {
        $this->mdp = $mdp;

        return $this;
    }

    /**
     * Get mdp
     *
     * @return string 
     */
    public function getMdp()
    {
        return $this->mdp;
    }

    /**
     * Get idClient
     *
     * @return integer 
     */
    public function getIdClient()
    {
        return $this->idClient;
    }


    /**
     * Set idAdresseMain
     *
     * @param \AppBundle\Entity\Adresse $idAdresseMain
     * @return Client
     */
    public function setIdAdresseMain(\AppBundle\Entity\Adresse $idAdresseMain = null)
    {
        $this->idAdresseMain = $idAdresseMain;

        return $this;
    }

    /**
     * Get Adresses
     *
     * @return collection
     */
    public function getAdresses()
    {
        return $this->adresses;
    }

    /**
     * Set Adresses
     *
     * @return Client
     */
    public function setAdresses($adresses)
    {
        foreach($adresses as $adresse) {
            $adresse->setClient($this);
        }
        $this->adresses = $adresses;

        return $this;
    }

    /**
     * add Adress
     *
     * @param \AppBundle\Entity\Adresse $adresse
     * @return Client
     * Should be addAddresse, but the symfony language recognition thinks "Adresses" is english
     */
    public function addAdress(\AppBundle\Entity\Adresse $adresse)
    {
        $adresse->setClient($this);
        $this->adresses->add($adresse);
        return $this;
    }

    /**
     * remove Adress
     *
     * Should be removeAddresse, but the symfony language recognition thinks "Adresses" is english
     */
    public function removeAdress()
    {
        //$this->Adresses->add($Adresse);
    }

    /**
     * Get idAdresseMain
     *
     * @return \AppBundle\Entity\Adresse 
     */
    public function getIdAdresseMain()
    {
        return $this->idAdresseMain;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->courriel;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->mdp;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->idClient,
            $this->courriel,
            $this->mdp,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->idClient,
            $this->courriel,
            $this->mdp,
        ) = unserialize($serialized);
    }
}
