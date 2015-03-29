<?php

namespace AppBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Livreur
 *
 * @ORM\Table(name="LIVREUR", uniqueConstraints={@ORM\UniqueConstraint(name="COURRIEL", columns={"COURRIEL"}), @ORM\UniqueConstraint(name="ID_LIVREUR", columns={"ID_LIVREUR"})})
 * @ORM\Entity
 */
class Livreur implements UserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_LIVREUR", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLivreur;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM", type="string", length=25, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="PRENOM", type="string", length=25, nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="TELEPHONE", type="string", length=25, nullable=true)
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
     * @var string
     *
     * @ORM\Column(name="ADRESSE", type="string", length=100, nullable=false)
     */
    private $adresse;

    /**
     * Get idLivreur
     *
     * @return integer 
     */
    public function getIdLivreur()
    {
        return $this->idLivreur;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Livreur
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
     * @return Livreur
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
     * @return Livreur
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
     * @return Livreur
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
     * @return Livreur
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
     * Set adresse
     *
     * @param string $adresse
     * @return Livreur
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
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
        return array('ROLE_LIVR');
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
            $this->idLivreur,
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
            $this->idLivreur,
            $this->courriel,
            $this->mdp,
        ) = unserialize($serialized);
    }
}