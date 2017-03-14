<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IndicateurTransport
 *
 * @ORM\Table(name="indicateur_transport")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\IndicateurTransportRepository")
 */
class IndicateurTransport
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
     * @ORM\Column(name="nbreJourAccidentCorporelTransportRoute", type="decimal", precision=5, scale=2, options={"default":0})
     */
    private $nbreJourAccidentCorporelTransportRoute;

    /**
     * @var string
     *
     * @ORM\Column(name="kmAccidentCorporelTransportRoute", type="decimal", precision=5, scale=2, options={"default":0})
     */
    private $kmAccidentCorporelTransportRoute;

    /**
     * @var int
     *
     * @ORM\Column(name="nbreJourAccidentCorporelTransportRail", type="decimal", precision=5, scale=2, options={"default":0})
     */
    private $nbreJourAccidentCorporelTransportRail;

    /**
     * @var string
     *
     * @ORM\Column(name="kmAccidentCorporelTransportRail", type="decimal", precision=5, scale=2, options={"default":0})
     */
    private $kmAccidentCorporelTransportRail;

    /**
     * @var int
     *
     * @ORM\Column(name="nbreJourIncidentTransportMaritime", type="decimal", precision=5, scale=2, options={"default":0})
     */
    private $nbreJourIncidentTransportMaritime;

    /**
     * @var string
     *
     * @ORM\Column(name="kmIncidentTransportMaritime", type="decimal", precision=5, scale=2, options={"default":0})
     */
    private $kmIncidentTransportMaritime;

    /**
     * @var int
     *
     * @ORM\Column(name="nbreJourFatalite", type="decimal", precision=5, scale=2, options={"default":0})
     */
    private $nbreJourFatalite;

    /**
     * @var string
     *
     * @ORM\Column(name="tauxSinistraliteMatiereDangereuse", type="decimal", precision=5, scale=2, options={"default":0})
     */
    private $tauxSinistraliteMatiereDangereuse;

    /**
     * @var string
     *
     * @ORM\Column(name="kmVehiculeLeger", type="decimal", precision=5, scale=2, options={"default":0})
     */
    private $kmVehiculeLeger;

    /**
     * @var string
     *
     * @ORM\Column(name="tauxSinistraliteVehiculeLeger", type="decimal", precision=5, scale=2, options={"default":0})
     */
    private $tauxSinistraliteVehiculeLeger;

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
     * Set nbreJourAccidentCorporelTransportRoute
     *
     * @param string $nbreJourAccidentCorporelTransportRoute
     *
     * @return IndicateurTransport
     */
    public function setNbreJourAccidentCorporelTransportRoute($nbreJourAccidentCorporelTransportRoute)
    {
        $this->nbreJourAccidentCorporelTransportRoute = $nbreJourAccidentCorporelTransportRoute;

        return $this;
    }

    /**
     * Get nbreJourAccidentCorporelTransportRoute
     *
     * @return string
     */
    public function getNbreJourAccidentCorporelTransportRoute()
    {
        return $this->nbreJourAccidentCorporelTransportRoute;
    }

    /**
     * Set kmAccidentCorporelTransportRoute
     *
     * @param string $kmAccidentCorporelTransportRoute
     *
     * @return IndicateurTransport
     */
    public function setKmAccidentCorporelTransportRoute($kmAccidentCorporelTransportRoute)
    {
        $this->kmAccidentCorporelTransportRoute = $kmAccidentCorporelTransportRoute;

        return $this;
    }

    /**
     * Get kmAccidentCorporelTransportRoute
     *
     * @return string
     */
    public function getKmAccidentCorporelTransportRoute()
    {
        return $this->kmAccidentCorporelTransportRoute;
    }

    /**
     * Set nbreJourAccidentCorporelTransportRail
     *
     * @param string $nbreJourAccidentCorporelTransportRail
     *
     * @return IndicateurTransport
     */
    public function setNbreJourAccidentCorporelTransportRail($nbreJourAccidentCorporelTransportRail)
    {
        $this->nbreJourAccidentCorporelTransportRail = $nbreJourAccidentCorporelTransportRail;

        return $this;
    }

    /**
     * Get nbreJourAccidentCorporelTransportRail
     *
     * @return string
     */
    public function getNbreJourAccidentCorporelTransportRail()
    {
        return $this->nbreJourAccidentCorporelTransportRail;
    }

    /**
     * Set kmAccidentCorporelTransportRail
     *
     * @param string $kmAccidentCorporelTransportRail
     *
     * @return IndicateurTransport
     */
    public function setKmAccidentCorporelTransportRail($kmAccidentCorporelTransportRail)
    {
        $this->kmAccidentCorporelTransportRail = $kmAccidentCorporelTransportRail;

        return $this;
    }

    /**
     * Get kmAccidentCorporelTransportRail
     *
     * @return string
     */
    public function getKmAccidentCorporelTransportRail()
    {
        return $this->kmAccidentCorporelTransportRail;
    }

    /**
     * Set nbreJourIncidentTransportMaritime
     *
     * @param string $nbreJourIncidentTransportMaritime
     *
     * @return IndicateurTransport
     */
    public function setNbreJourIncidentTransportMaritime($nbreJourIncidentTransportMaritime)
    {
        $this->nbreJourIncidentTransportMaritime = $nbreJourIncidentTransportMaritime;

        return $this;
    }

    /**
     * Get nbreJourIncidentTransportMaritime
     *
     * @return string
     */
    public function getNbreJourIncidentTransportMaritime()
    {
        return $this->nbreJourIncidentTransportMaritime;
    }

    /**
     * Set kmIncidentTransportMaritime
     *
     * @param string $kmIncidentTransportMaritime
     *
     * @return IndicateurTransport
     */
    public function setKmIncidentTransportMaritime($kmIncidentTransportMaritime)
    {
        $this->kmIncidentTransportMaritime = $kmIncidentTransportMaritime;

        return $this;
    }

    /**
     * Get kmIncidentTransportMaritime
     *
     * @return string
     */
    public function getKmIncidentTransportMaritime()
    {
        return $this->kmIncidentTransportMaritime;
    }

    /**
     * Set nbreJourFatalite
     *
     * @param string $nbreJourFatalite
     *
     * @return IndicateurTransport
     */
    public function setNbreJourFatalite($nbreJourFatalite)
    {
        $this->nbreJourFatalite = $nbreJourFatalite;

        return $this;
    }

    /**
     * Get nbreJourFatalite
     *
     * @return string
     */
    public function getNbreJourFatalite()
    {
        return $this->nbreJourFatalite;
    }

    /**
     * Set tauxSinistraliteMatiereDangereuse
     *
     * @param string $tauxSinistraliteMatiereDangereuse
     *
     * @return IndicateurTransport
     */
    public function setTauxSinistraliteMatiereDangereuse($tauxSinistraliteMatiereDangereuse)
    {
        $this->tauxSinistraliteMatiereDangereuse = $tauxSinistraliteMatiereDangereuse;

        return $this;
    }

    /**
     * Get tauxSinistraliteMatiereDangereuse
     *
     * @return string
     */
    public function getTauxSinistraliteMatiereDangereuse()
    {
        return $this->tauxSinistraliteMatiereDangereuse;
    }

    /**
     * Set kmVehiculeLeger
     *
     * @param string $kmVehiculeLeger
     *
     * @return IndicateurTransport
     */
    public function setKmVehiculeLeger($kmVehiculeLeger)
    {
        $this->kmVehiculeLeger = $kmVehiculeLeger;

        return $this;
    }

    /**
     * Get kmVehiculeLeger
     *
     * @return string
     */
    public function getKmVehiculeLeger()
    {
        return $this->kmVehiculeLeger;
    }

    /**
     * Set tauxSinistraliteVehiculeLeger
     *
     * @param string $tauxSinistraliteVehiculeLeger
     *
     * @return IndicateurTransport
     */
    public function setTauxSinistraliteVehiculeLeger($tauxSinistraliteVehiculeLeger)
    {
        $this->tauxSinistraliteVehiculeLeger = $tauxSinistraliteVehiculeLeger;

        return $this;
    }

    /**
     * Get tauxSinistraliteVehiculeLeger
     *
     * @return string
     */
    public function getTauxSinistraliteVehiculeLeger()
    {
        return $this->tauxSinistraliteVehiculeLeger;
    }
}
