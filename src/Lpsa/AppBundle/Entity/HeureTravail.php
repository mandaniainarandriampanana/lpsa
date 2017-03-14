<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * HeureTravail
 *
 * @ORM\Table(name="heure_travail")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\HeureTravailRepository")
 */
class HeureTravail
{
    /**
     * @var HeureTravailCategorie
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\HeureTravailCategorie", inversedBy="heureTravails")
     * @ORM\JoinColumn(name="heure_travail_categorie_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $heureTravailCategorie;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="heure", type="decimal", precision=20, scale=2)
     */
    private $heure;
    /**
     * @var string
     *
     * @ORM\Column(name="mois", type="string", length=255)
     */
    private $mois;
    /**
     * @var int
     *
     * @ORM\Column(name="annee", type="integer", length=4)
     */
    private $annee;
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set heure
     *
     * @param string $heure
     *
     * @return HeureTravail
     */
    public function setHeure($heure)
    {
        $this->heure = $heure;

        return $this;
    }

    /**
     * Get heure
     *
     * @return string
     */
    public function getHeure()
    {
        return $this->heure;
    }

    /**
     * Set mois
     *
     * @param string $mois
     *
     * @return HeureTravail
     */
    public function setMois($mois)
    {
        $this->mois = $mois;

        return $this;
    }

    /**
     * Get mois
     *
     * @return string
     */
    public function getMois()
    {
        return $this->mois;
    }

    /**
     * Set annee
     *
     * @param string $annee
     *
     * @return HeureTravail
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return string
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set heureTravailCategorie
     *
     * @param \Lpsa\AppBundle\Entity\HeureTravailCategorie $heureTravailCategorie
     *
     * @return HeureTravail
     */
    public function setHeureTravailCategorie(\Lpsa\AppBundle\Entity\HeureTravailCategorie $heureTravailCategorie = null)
    {
        $this->heureTravailCategorie = $heureTravailCategorie;

        return $this;
    }

    /**
     * Get heureTravailCategorie
     *
     * @return \Lpsa\AppBundle\Entity\HeureTravailCategorie
     */
    public function getHeureTravailCategorie()
    {
        return $this->heureTravailCategorie;
    }
}
