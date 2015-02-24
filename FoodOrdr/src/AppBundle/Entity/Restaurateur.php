<?php

namespace AppBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Restaurateur
 *
 * @ORM\Table(name="RESTAURATEUR", uniqueConstraints={@ORM\UniqueConstraint(name="COURRIEL", columns={"COURRIEL"}), @ORM\UniqueConstraint(name="ID_RESTAURATEUR", columns={"ID_RESTAURATEUR"})}, indexes={@ORM\Index(name="FK_ID_ENTREPRENEUR", columns={"ID_ENTREPRENEUR"})})
 * @ORM\Entity
 */
class Restaurateur implements UserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_RESTAURANT", type="integer", nullable=true)
     */
    private $idRestaurant;

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
     * @var string
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
     * @ORM\Column(name="ID_RESTAURATEUR", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRestaurateur;

    /**
     * @var \AppBundle\Entity\Entrepreneur
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Entrepreneur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_ENTREPRENEUR", referencedColumnName="ID_ENTREPRENEUR")
     * })
     */
    private $idEntrepreneur;



    /**
     * Set idRestaurant
     *
     * @param integer $idRestaurant
     * @return Restaurateur
     */
    public function setIdRestaurant($idRestaurant)
    {
        $this->idRestaurant = $idRestaurant;

        return $this;
    }

    /**
     * Get idRestaurant
     *
     * @return integer 
     */
    public function getIdRestaurant()
    {
        return $this->idRestaurant;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Restaurateur
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
     * @return Restaurateur
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
     * Set telephone
     *
     * @param string $telephone
     * @return Restaurateur
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
     * @return Restaurateur
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
     * @return Restaurateur
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
     * Get idRestaurateur
     *
     * @return integer 
     */
    public function getIdRestaurateur()
    {
        return $this->idRestaurateur;
    }

    /**
     * Set idEntrepreneur
     *
     * @param \AppBundle\Entity\Entrepreneur $idEntrepreneur
     * @return Restaurateur
     */
    public function setIdEntrepreneur(\AppBundle\Entity\Entrepreneur $idEntrepreneur = null)
    {
        $this->idEntrepreneur = $idEntrepreneur;

        return $this;
    }

    /**
     * Get idEntrepreneur
     *
     * @return \AppBundle\Entity\Entrepreneur 
     */
    public function getIdEntrepreneur()
    {
        return $this->idEntrepreneur;
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
        return array('ROLE_REST');
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
            $this->idRestaurateur,
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
            $this->idRestaurateur,
            $this->courriel,
            $this->mdp,
        ) = unserialize($serialized);
    }
}
