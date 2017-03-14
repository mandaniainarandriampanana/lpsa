<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Decanteur
 *
 * @ORM\Table(name="decanteur")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\DecanteurRepository")
 */
class Decanteur
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="nbreEchantillonPreleve", type="integer", options={"default":0})
     */
    private $nbreEchantillonPreleve;

    /**
     * @var int
     *
     * @ORM\Column(name="nbreEchantillonAnalyse", type="integer", options={"default":0})
     */
    private $nbreEchantillonAnalyse;

    /**
     * @var int
     *
     * @ORM\Column(name="nbreAnomalieReleve", type="integer", options={"default":0})
     */
    private $nbreAnomalieReleve;

    /**
     * @var string
     *
     * @ORM\Column(name="tauxNonConformite", type="decimal", precision=5, scale=2, options={"default":0})
     */
    private $tauxNonConformite;

    /**
     * @var int
     *
     * @ORM\Column(name="mois", type="integer")
     */
    private $mois;

    /**
     * @var int
     *
     * @ORM\Column(name="annee", type="integer")
     */
    private $annee;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mois
     *
     * @param integer $mois
     *
     * @return Visite
     */
    public function setMois($mois)
    {
        $this->mois = $mois;
    
        return $this;
    }

    /**
     * Get mois
     *
     * @return integer
     */
    public function getMois()
    {
        return $this->mois;
    }

    /**
     * Set annee
     *
     * @param integer $annee
     *
     * @return Visite
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;
    
        return $this;
    }

    /**
     * Get annee
     *
     * @return integer
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set nbreEchantillonPreleve
     *
     * @param integer $nbreEchantillonPreleve
     *
     * @return Piezometre
     */
    public function setNbreEchantillonPreleve($nbreEchantillonPreleve)
    {
        $this->nbreEchantillonPreleve = $nbreEchantillonPreleve;

        return $this;
    }

    /**
     * Get nbreEchantillonPreleve
     *
     * @return integer
     */
    public function getNbreEchantillonPreleve()
    {
        return $this->nbreEchantillonPreleve;
    }

    /**
     * Set nbreEchantillonAnalyse
     *
     * @param integer $nbreEchantillonAnalyse
     *
     * @return Piezometre
     */
    public function setNbreEchantillonAnalyse($nbreEchantillonAnalyse)
    {
        $this->nbreEchantillonAnalyse = $nbreEchantillonAnalyse;

        return $this;
    }

    /**
     * Get nbreEchantillonAnalyse
     *
     * @return integer
     */
    public function getNbreEchantillonAnalyse()
    {
        return $this->nbreEchantillonAnalyse;
    }

    /**
     * Set nbreAnomalieReleve
     *
     * @param integer $nbreAnomalieReleve
     *
     * @return Piezometre
     */
    public function setNbreAnomalieReleve($nbreAnomalieReleve)
    {
        $this->nbreAnomalieReleve = $nbreAnomalieReleve;

        return $this;
    }

    /**
     * Get nbreAnomalieReleve
     *
     * @return integer
     */
    public function getNbreAnomalieReleve()
    {
        return $this->nbreAnomalieReleve;
    }

    /**
     * Set tauxNonConformite
     *
     * @param string $tauxNonConformite
     *
     * @return Piezometre
     */
    public function setTauxNonConformite($tauxNonConformite)
    {
        $this->tauxNonConformite = $tauxNonConformite;

        return $this;
    }

    /**
     * Get tauxNonConformite
     *
     * @return string
     */
    public function getTauxNonConformite()
    {
        return $this->tauxNonConformite;
    }
}
