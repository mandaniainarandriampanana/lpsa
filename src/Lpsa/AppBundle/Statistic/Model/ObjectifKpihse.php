<?php

namespace Lpsa\AppBundle\Statistic\Model;

class ObjectifKpihse
{
    private $nbreFatLpsa = 0;

    private $nbreFatContracte = 0;

    private $nbreFatTiers = 0;

    private $nbreLtiLpsa = 0;

    private $nbreLtiContracte = 0;

    private $rwc = 0;

    private $nbreMtLpsa = 0;

    private $nbreMtContracte = 0;

    private $nbreFaLpsa = 0;

    private $nbreFaContracte = 0;

    private $tri = 0;

    private $trir12Mois = '';

    private $ltir12Mois = '';

    private $trir = '';

    private $ltir = '';

    private $far = '';

    private $far12Mois = '';

    private $nbreAccidentDepotAvecArret = 0;

    private $nbreAccidentTransportTerrestreAvecArret = 0;

    private $nbreLtiTransportTerrestreAvecArret = 0;

    private $nbreAccidentTransportMaritimeAvecArret = 0;

    private $nbreAccidentSiegeAvecArret = 0;

    private $nbreAccidentDepotSansArret = 0;

    private $nbreAccidentTransportTerrestreSansArret = 0;

    private $nbreLtiTransportTerrestreSansArret = 0;

    private $nbreAccidentTransportMaritimeSansArret = 0;

    private $nbreAccidentSiegeSansArret = 0;

    private $nbreAgression = 0;

    private $nbreVol = 0;

    private $nbreIntrusion = 0;

    private $nbreJourDernierAccidentCorporelRoute = 0;

    private $kmDernierAccidentCorporelRoute = 0;

    private $nbreJourDernierAccidentCorporelRail = 0;

    private $kmDernierAccidentCorporelRail = 0;

    private $nbreJourDernierIncidentMaritime = 0;

    private $milesDernierIncidentMaritime = 0;

    private $nbreJourDernierFatalite = 0;

    private $tauxSinistralite = '0.0';

    private $tauxSinistraliteTousMode = '0.0';

    private $kmVehiculeLeger = 0;

    private $tauxSinistraliteVehiculeLeger = '0.0';

    private $nbreExercicePoi = 0;

    private $nbreExerciceMiniPoi = 0;

    private $nbreExercicePum = 0;

    private $nbreExerciceCombine = 0;

    private $nbreExerciceCmc = 0;

    private $nbreVisiteCodir = 0;

    private $nbreEvenementReporte = 0;

    private $indiceReporting = '0.0';

    private $nbrePresqueAccident = 0;

    private $nbreActeSituationDangereuse = 0;

    private $nbreIncidentPotentiel = 0;

    private $nbreAnalyseArbreCauseRealise = 0;

    private $zoneEtancheSup159 = 0;

    private $zoneEtancheInf159 = 0;

    private $zoneNonEtancheSup159 = 0;

    private $zoneNonEtancheInf159 = 0;

    private $fuiteProduitNonMesurable = 0;

    private $pollutionMarine = 0;

    private $piezometreNbEchantillonPreleve = 0;

    private $piezometreNbEchantillonAnalyse = 0;

    private $piezometreNbAnomalieReleve = 0;

    private $piezometreTauxNonConformite = '0.0';

    private $decanteurNbEchantillonPreleve = 0;

    private $decanteurNbEchantillonAnalyse = 0;

    private $decanteurNbAnomalieReleve = 0;

    private $decanteurTauxNonConformite = '0.0';

    private $laboratoireNbEchantillonPreleve = 0;

    private $laboratoireNbEchantillonAnalyse = 0;

    private $laboratoireNbAnomalieReleve = 0;

    private $laboratoireTauxNonConformite = '0.0';

    private $laboratoireResultatEssaiCirculaire = '0.0';

    private $nbreNonConformiteCloture = 0;

    private $nbreNonConformiteNonEchue = 0;

    private $nbreOVERDUE = 0;

    private $pourcentageOVERDUE = '0.0';

    private $dateEnd;

    private $toolboxSiege = 0;

    private $toolboxDepot = 0;
    
    private $toolboxSct = 0;

    /**
     * Set nbreFatLpsa
     *
     * @param integer $nbreFatLpsa
     *
     * @return ObjectifKpihse
     */
    public function setNbreFatLpsa($nbreFatLpsa)
    {
        $this->nbreFatLpsa = $nbreFatLpsa;

        return $this;
    }

    /**
     * Get nbreFatLpsa
     *
     * @return integer
     */
    public function getNbreFatLpsa()
    {
        return $this->nbreFatLpsa;
    }

    /**
     * Set nbreFatContracte
     *
     * @param integer $nbreFatContracte
     *
     * @return ObjectifKpihse
     */
    public function setNbreFatContracte($nbreFatContracte)
    {
        $this->nbreFatContracte = $nbreFatContracte;

        return $this;
    }

    /**
     * Get nbreFatContracte
     *
     * @return integer
     */
    public function getNbreFatContracte()
    {
        return $this->nbreFatContracte;
    }

    /**
     * Set nbreFatTiers
     *
     * @param integer $nbreFatTiers
     *
     * @return ObjectifKpihse
     */
    public function setNbreFatTiers($nbreFatTiers)
    {
        $this->nbreFatTiers = $nbreFatTiers;

        return $this;
    }

    /**
     * Get nbreFatTiers
     *
     * @return integer
     */
    public function getNbreFatTiers()
    {
        return $this->nbreFatTiers;
    }

    public function getTotalFat(){
        return $this->getNbreFatLpsa() + $this->getNbreFatContracte() + $this->getNbreFatTiers();
    }

    /**
     * Set nbreLtiLpsa
     *
     * @param integer $nbreLtiLpsa
     *
     * @return ObjectifKpihse
     */
    public function setNbreLtiLpsa($nbreLtiLpsa)
    {
        $this->nbreLtiLpsa = $nbreLtiLpsa;

        return $this;
    }

    /**
     * Get nbreLtiLpsa
     *
     * @return integer
     */
    public function getNbreLtiLpsa()
    {
        return $this->nbreLtiLpsa;
    }

    /**
     * Set nbreLtiContracte
     *
     * @param integer $nbreLtiContracte
     *
     * @return ObjectifKpihse
     */
    public function setNbreLtiContracte($nbreLtiContracte)
    {
        $this->nbreLtiContracte = $nbreLtiContracte;

        return $this;
    }

    /**
     * Get nbreLtiContracte
     *
     * @return integer
     */
    public function getNbreLtiContracte()
    {
        return $this->nbreLtiContracte;
    }

    public function getTotalLti(){
        return $this->getNbreLtiLpsa() + $this->getNbreLtiContracte();
    }

    /**
     * Set rwc
     *
     * @param integer $rwc
     *
     * @return ObjectifKpihse
     */
    public function setRwc($rwc)
    {
        $this->rwc = $rwc;

        return $this;
    }

    /**
     * Get rwc
     *
     * @return integer
     */
    public function getRwc()
    {
        return $this->rwc;
    }

    /**
     * Set nbreMtLpsa
     *
     * @param integer $nbreMtLpsa
     *
     * @return ObjectifKpihse
     */
    public function setNbreMtLpsa($nbreMtLpsa)
    {
        $this->nbreMtLpsa = $nbreMtLpsa;

        return $this;
    }

    /**
     * Get nbreMtLpsa
     *
     * @return integer
     */
    public function getNbreMtLpsa()
    {
        return $this->nbreMtLpsa;
    }

    /**
     * Set nbreMtContracte
     *
     * @param integer $nbreMtContracte
     *
     * @return ObjectifKpihse
     */
    public function setNbreMtContracte($nbreMtContracte)
    {
        $this->nbreMtContracte = $nbreMtContracte;

        return $this;
    }

    /**
     * Get nbreMtContracte
     *
     * @return integer
     */
    public function getNbreMtContracte()
    {
        return $this->nbreMtContracte;
    }

    public function getTotalMt(){
        return $this->getNbreMtLpsa() + $this->getNbreMtContracte();
    }

    /**
     * Set nbreFaLpsa
     *
     * @param integer $nbreFaLpsa
     *
     * @return ObjectifKpihse
     */
    public function setNbreFaLpsa($nbreFaLpsa)
    {
        $this->nbreFaLpsa = $nbreFaLpsa;

        return $this;
    }

    /**
     * Get nbreFaLpsa
     *
     * @return integer
     */
    public function getNbreFaLpsa()
    {
        return $this->nbreFaLpsa;
    }

    /**
     * Set nbreFaContracte
     *
     * @param integer $nbreFaContracte
     *
     * @return ObjectifKpihse
     */
    public function setNbreFaContracte($nbreFaContracte)
    {
        $this->nbreFaContracte = $nbreFaContracte;

        return $this;
    }

    /**
     * Get nbreFaContracte
     *
     * @return integer
     */
    public function getNbreFaContracte()
    {
        return $this->nbreFaContracte;
    }

    public function getTotalFa(){
        return $this->getNbreFaLpsa() + $this->getNbreFaContracte();
    }

    /**
     * Set tri
     *
     * @param integer $tri
     *
     * @return ObjectifKpihse
     */
    public function setTri($tri)
    {
        $this->tri = $tri;

        return $this;
    }

    /**
     * Get tri
     *
     * @return integer
     */
    public function getTri()
    {
        return $this->tri;
    }

    /**
     * Set trir12Mois
     *
     * @param string $trir12Mois
     *
     * @return ObjectifKpihse
     */
    public function setTrir12Mois($trir12Mois)
    {
        $this->trir12Mois = $trir12Mois;

        return $this;
    }

    /**
     * Get trir12Mois
     *
     * @return string
     */
    public function getTrir12Mois()
    {
        return $this->trir12Mois;
    }

    /**
     * Set ltir12Mois
     *
     * @param string $ltir12Mois
     *
     * @return ObjectifKpihse
     */
    public function setLtir12Mois($ltir12Mois)
    {
        $this->ltir12Mois = $ltir12Mois;

        return $this;
    }

    /**
     * Get ltir12Mois
     *
     * @return string
     */
    public function getLtir12Mois()
    {
        return $this->ltir12Mois;
    }

    /**
     * Set trir
     *
     * @param string $trir
     *
     * @return ObjectifKpihse
     */
    public function setTrir($trir)
    {
        $this->trir = $trir;

        return $this;
    }

    /**
     * Get trir
     *
     * @return string
     */
    public function getTrir()
    {
        return $this->trir;
    }

    /**
     * Set ltir
     *
     * @param string $ltir
     *
     * @return ObjectifKpihse
     */
    public function setLtir($ltir)
    {
        $this->ltir = $ltir;

        return $this;
    }

    /**
     * Get ltir
     *
     * @return string
     */
    public function getLtir()
    {
        return $this->ltir;
    }

    /**
     * Set far
     *
     * @param string $far
     *
     * @return ObjectifKpihse
     */
    public function setFar($far)
    {
        $this->far = $far;

        return $this;
    }

    /**
     * Get far
     *
     * @return string
     */
    public function getFar()
    {
        return $this->far;
    }

    /**
     * Set far12Mois
     *
     * @param string $far12Mois
     *
     * @return ObjectifKpihse
     */
    public function setFar12Mois($far12Mois)
    {
        $this->far12Mois = $far12Mois;

        return $this;
    }

    /**
     * Get far12Mois
     *
     * @return string
     */
    public function getFar12Mois()
    {
        return $this->far12Mois;
    }

    /**
     * Set nbreAccidentDepotAvecArret
     *
     * @param integer $nbreAccidentDepotAvecArret
     *
     * @return ObjectifKpihse
     */
    public function setNbreAccidentDepotAvecArret($nbreAccidentDepotAvecArret)
    {
        $this->nbreAccidentDepotAvecArret = $nbreAccidentDepotAvecArret;

        return $this;
    }

    /**
     * Get nbreAccidentDepotAvecArret
     *
     * @return integer
     */
    public function getNbreAccidentDepotAvecArret()
    {
        return $this->nbreAccidentDepotAvecArret;
    }

    /**
     * Set nbreAccidentTransportTerrestreAvecArret
     *
     * @param integer $nbreAccidentTransportTerrestreAvecArret
     *
     * @return ObjectifKpihse
     */
    public function setNbreAccidentTransportTerrestreAvecArret($nbreAccidentTransportTerrestreAvecArret)
    {
        $this->nbreAccidentTransportTerrestreAvecArret = $nbreAccidentTransportTerrestreAvecArret;

        return $this;
    }

    /**
     * Get nbreAccidentTransportTerrestreAvecArret
     *
     * @return integer
     */
    public function getNbreAccidentTransportTerrestreAvecArret()
    {
        return $this->nbreAccidentTransportTerrestreAvecArret;
    }

    /**
     * Set nbreLtiTransportTerrestreAvecArret
     *
     * @param integer $nbreLtiTransportTerrestreAvecArret
     *
     * @return ObjectifKpihse
     */
    public function setNbreLtiTransportTerrestreAvecArret($nbreLtiTransportTerrestreAvecArret)
    {
        $this->nbreLtiTransportTerrestreAvecArret = $nbreLtiTransportTerrestreAvecArret;

        return $this;
    }

    /**
     * Get nbreLtiTransportTerrestreAvecArret
     *
     * @return integer
     */
    public function getNbreLtiTransportTerrestreAvecArret()
    {
        return $this->nbreLtiTransportTerrestreAvecArret;
    }

    /**
     * Set nbreAccidentTransportMaritimeAvecArret
     *
     * @param integer $nbreAccidentTransportMaritimeAvecArret
     *
     * @return ObjectifKpihse
     */
    public function setNbreAccidentTransportMaritimeAvecArret($nbreAccidentTransportMaritimeAvecArret)
    {
        $this->nbreAccidentTransportMaritimeAvecArret = $nbreAccidentTransportMaritimeAvecArret;

        return $this;
    }

    /**
     * Get nbreAccidentTransportMaritimeAvecArret
     *
     * @return integer
     */
    public function getNbreAccidentTransportMaritimeAvecArret()
    {
        return $this->nbreAccidentTransportMaritimeAvecArret;
    }

    /**
     * Set nbreAccidentSiegeAvecArret
     *
     * @param integer $nbreAccidentSiegeAvecArret
     *
     * @return ObjectifKpihse
     */
    public function setNbreAccidentSiegeAvecArret($nbreAccidentSiegeAvecArret)
    {
        $this->nbreAccidentSiegeAvecArret = $nbreAccidentSiegeAvecArret;

        return $this;
    }

    /**
     * Get nbreAccidentSiegeAvecArret
     *
     * @return integer
     */
    public function getNbreAccidentSiegeAvecArret()
    {
        return $this->nbreAccidentSiegeAvecArret;
    }

    public function getCumulAvecArret(){
        return $this->getNbreAccidentSiegeAvecArret() + $this->getNbreAccidentTransportMaritimeAvecArret() + $this->getNbreAccidentTransportTerrestreAvecArret() + $this->getNbreAccidentDepotAvecArret();
    }

    /**
     * Set nbreAccidentDepotSansArret
     *
     * @param integer $nbreAccidentDepotSansArret
     *
     * @return ObjectifKpihse
     */
    public function setNbreAccidentDepotSansArret($nbreAccidentDepotSansArret)
    {
        $this->nbreAccidentDepotSansArret = $nbreAccidentDepotSansArret;

        return $this;
    }

    /**
     * Get nbreAccidentDepotSansArret
     *
     * @return integer
     */
    public function getNbreAccidentDepotSansArret()
    {
        return $this->nbreAccidentDepotSansArret;
    }

    /**
     * Set nbreAccidentTransportTerrestreSansArret
     *
     * @param integer $nbreAccidentTransportTerrestreSansArret
     *
     * @return ObjectifKpihse
     */
    public function setNbreAccidentTransportTerrestreSansArret($nbreAccidentTransportTerrestreSansArret)
    {
        $this->nbreAccidentTransportTerrestreSansArret = $nbreAccidentTransportTerrestreSansArret;

        return $this;
    }

    /**
     * Get nbreAccidentTransportTerrestreSansArret
     *
     * @return integer
     */
    public function getNbreAccidentTransportTerrestreSansArret()
    {
        return $this->nbreAccidentTransportTerrestreSansArret;
    }

    /**
     * Set nbreLtiTransportTerrestreSansArret
     *
     * @param integer $nbreLtiTransportTerrestreSansArret
     *
     * @return ObjectifKpihse
     */
    public function setNbreLtiTransportTerrestreSansArret($nbreLtiTransportTerrestreSansArret)
    {
        $this->nbreLtiTransportTerrestreSansArret = $nbreLtiTransportTerrestreSansArret;

        return $this;
    }

    /**
     * Get nbreLtiTransportTerrestreSansArret
     *
     * @return integer
     */
    public function getNbreLtiTransportTerrestreSansArret()
    {
        return $this->nbreLtiTransportTerrestreSansArret;
    }

    /**
     * Set nbreAccidentTransportMaritimeSansArret
     *
     * @param integer $nbreAccidentTransportMaritimeSansArret
     *
     * @return ObjectifKpihse
     */
    public function setNbreAccidentTransportMaritimeSansArret($nbreAccidentTransportMaritimeSansArret)
    {
        $this->nbreAccidentTransportMaritimeSansArret = $nbreAccidentTransportMaritimeSansArret;

        return $this;
    }

    /**
     * Get nbreAccidentTransportMaritimeSansArret
     *
     * @return integer
     */
    public function getNbreAccidentTransportMaritimeSansArret()
    {
        return $this->nbreAccidentTransportMaritimeSansArret;
    }

    /**
     * Set nbreAccidentSiegeSansArret
     *
     * @param integer $nbreAccidentSiegeSansArret
     *
     * @return ObjectifKpihse
     */
    public function setNbreAccidentSiegeSansArret($nbreAccidentSiegeSansArret)
    {
        $this->nbreAccidentSiegeSansArret = $nbreAccidentSiegeSansArret;

        return $this;
    }

    /**
     * Get nbreAccidentSiegeSansArret
     *
     * @return integer
     */
    public function getNbreAccidentSiegeSansArret()
    {
        return $this->nbreAccidentSiegeSansArret;
    }

    public function getCumulSansArret(){
        return $this->getNbreAccidentSiegeSansArret() + $this->getNbreAccidentTransportMaritimeSansArret() + $this->getNbreAccidentTransportTerrestreSansArret() + $this->getNbreAccidentDepotSansArret();
    }

    /**
     * Set nbreAgression
     *
     * @param integer $nbreAgression
     *
     * @return ObjectifKpihse
     */
    public function setNbreAgression($nbreAgression)
    {
        $this->nbreAgression = $nbreAgression;

        return $this;
    }

    /**
     * Get nbreAgression
     *
     * @return integer
     */
    public function getNbreAgression()
    {
        return $this->nbreAgression;
    }

    /**
     * Set nbreVol
     *
     * @param integer $nbreVol
     *
     * @return ObjectifKpihse
     */
    public function setNbreVol($nbreVol)
    {
        $this->nbreVol = $nbreVol;

        return $this;
    }

    /**
     * Get nbreVol
     *
     * @return integer
     */
    public function getNbreVol()
    {
        return $this->nbreVol;
    }

    /**
     * Set nbreIntrusion
     *
     * @param integer $nbreIntrusion
     *
     * @return ObjectifKpihse
     */
    public function setNbreIntrusion($nbreIntrusion)
    {
        $this->nbreIntrusion = $nbreIntrusion;

        return $this;
    }

    /**
     * Get nbreIntrusion
     *
     * @return integer
     */
    public function getNbreIntrusion()
    {
        return $this->nbreIntrusion;
    }

    /**
     * Set nbreJourDernierAccidentCorporelRoute
     *
     * @param string $nbreJourDernierAccidentCorporelRoute
     *
     * @return ObjectifKpihse
     */
    public function setNbreJourDernierAccidentCorporelRoute($nbreJourDernierAccidentCorporelRoute)
    {
        $this->nbreJourDernierAccidentCorporelRoute = $nbreJourDernierAccidentCorporelRoute;

        return $this;
    }

    /**
     * Get nbreJourDernierAccidentCorporelRoute
     *
     * @return string
     */
    public function getNbreJourDernierAccidentCorporelRoute()
    {
        return $this->nbreJourDernierAccidentCorporelRoute;
    }

    /**
     * Set kmDernierAccidentCorporelRoute
     *
     * @param string $kmDernierAccidentCorporelRoute
     *
     * @return ObjectifKpihse
     */
    public function setKmDernierAccidentCorporelRoute($kmDernierAccidentCorporelRoute)
    {
        $this->kmDernierAccidentCorporelRoute = $kmDernierAccidentCorporelRoute;

        return $this;
    }

    /**
     * Get kmDernierAccidentCorporelRoute
     *
     * @return string
     */
    public function getKmDernierAccidentCorporelRoute()
    {
        return $this->kmDernierAccidentCorporelRoute;
    }

    /**
     * Set nbreJourDernierAccidentCorporelRail
     *
     * @param string $nbreJourDernierAccidentCorporelRail
     *
     * @return ObjectifKpihse
     */
    public function setNbreJourDernierAccidentCorporelRail($nbreJourDernierAccidentCorporelRail)
    {
        $this->nbreJourDernierAccidentCorporelRail = $nbreJourDernierAccidentCorporelRail;

        return $this;
    }

    /**
     * Get nbreJourDernierAccidentCorporelRail
     *
     * @return string
     */
    public function getNbreJourDernierAccidentCorporelRail()
    {
        return $this->nbreJourDernierAccidentCorporelRail;
    }

    /**
     * Set kmDernierAccidentCorporelRail
     *
     * @param string $kmDernierAccidentCorporelRail
     *
     * @return ObjectifKpihse
     */
    public function setKmDernierAccidentCorporelRail($kmDernierAccidentCorporelRail)
    {
        $this->kmDernierAccidentCorporelRail = $kmDernierAccidentCorporelRail;

        return $this;
    }

    /**
     * Get kmDernierAccidentCorporelRail
     *
     * @return string
     */
    public function getKmDernierAccidentCorporelRail()
    {
        return $this->kmDernierAccidentCorporelRail;
    }

    /**
     * Set nbreJourDernierIncidentMaritime
     *
     * @param string $nbreJourDernierIncidentMaritime
     *
     * @return ObjectifKpihse
     */
    public function setNbreJourDernierIncidentMaritime($nbreJourDernierIncidentMaritime)
    {
        $this->nbreJourDernierIncidentMaritime = $nbreJourDernierIncidentMaritime;

        return $this;
    }

    /**
     * Get nbreJourDernierIncidentMaritime
     *
     * @return string
     */
    public function getNbreJourDernierIncidentMaritime()
    {
        return $this->nbreJourDernierIncidentMaritime;
    }

    /**
     * Set milesDernierIncidentMaritime
     *
     * @param string $milesDernierIncidentMaritime
     *
     * @return ObjectifKpihse
     */
    public function setMilesDernierIncidentMaritime($milesDernierIncidentMaritime)
    {
        $this->milesDernierIncidentMaritime = $milesDernierIncidentMaritime;

        return $this;
    }

    /**
     * Get milesDernierIncidentMaritime
     *
     * @return string
     */
    public function getMilesDernierIncidentMaritime()
    {
        return $this->milesDernierIncidentMaritime;
    }

    /**
     * Set nbreJourDernierFatalite
     *
     * @param string $nbreJourDernierFatalite
     *
     * @return ObjectifKpihse
     */
    public function setNbreJourDernierFatalite($nbreJourDernierFatalite)
    {
        $this->nbreJourDernierFatalite = $nbreJourDernierFatalite;

        return $this;
    }

    /**
     * Get nbreJourDernierFatalite
     *
     * @return string
     */
    public function getNbreJourDernierFatalite()
    {
        return $this->nbreJourDernierFatalite;
    }

    /**
     * Set tauxSinistralite
     *
     * @param string $tauxSinistralite
     *
     * @return ObjectifKpihse
     */
    public function setTauxSinistralite($tauxSinistralite)
    {
        $this->tauxSinistralite = $tauxSinistralite;

        return $this;
    }

    /**
     * Get tauxSinistralite
     *
     * @return string
     */
    public function getTauxSinistralite()
    {
        return $this->tauxSinistralite;
    }

    /**
     * Set tauxSinistraliteTousMode
     *
     * @param string $tauxSinistraliteTousMode
     *
     * @return ObjectifKpihse
     */
    public function setTauxSinistraliteTousMode($tauxSinistraliteTousMode)
    {
        $this->tauxSinistraliteTousMode = $tauxSinistraliteTousMode;

        return $this;
    }

    /**
     * Get tauxSinistraliteTousMode
     *
     * @return string
     */
    public function getTauxSinistraliteTousMode()
    {
        return $this->tauxSinistraliteTousMode;
    }

    /**
     * Set kmVehiculeLeger
     *
     * @param string $kmVehiculeLeger
     *
     * @return ObjectifKpihse
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
     * @return ObjectifKpihse
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

    /**
     * Set nbreExercicePoi
     *
     * @param integer $nbreExercicePoi
     *
     * @return ObjectifKpihse
     */
    public function setNbreExercicePoi($nbreExercicePoi)
    {
        $this->nbreExercicePoi = $nbreExercicePoi;

        return $this;
    }

    /**
     * Get nbreExercicePoi
     *
     * @return integer
     */
    public function getNbreExercicePoi()
    {
        return $this->nbreExercicePoi;
    }

    /**
     * Set nbreExerciceMiniPoi
     *
     * @param integer $nbreExerciceMiniPoi
     *
     * @return ObjectifKpihse
     */
    public function setNbreExerciceMiniPoi($nbreExerciceMiniPoi)
    {
        $this->nbreExerciceMiniPoi = $nbreExerciceMiniPoi;

        return $this;
    }

    /**
     * Get nbreExerciceMiniPoi
     *
     * @return integer
     */
    public function getNbreExerciceMiniPoi()
    {
        return $this->nbreExerciceMiniPoi;
    }

    /**
     * Set nbreExercicePum
     *
     * @param integer $nbreExercicePum
     *
     * @return ObjectifKpihse
     */
    public function setNbreExercicePum($nbreExercicePum)
    {
        $this->nbreExercicePum = $nbreExercicePum;

        return $this;
    }

    /**
     * Get nbreExercicePum
     *
     * @return integer
     */
    public function getNbreExercicePum()
    {
        return $this->nbreExercicePum;
    }

    /**
     * Set nbreExerciceCombine
     *
     * @param integer $nbreExerciceCombine
     *
     * @return ObjectifKpihse
     */
    public function setNbreExerciceCombine($nbreExerciceCombine)
    {
        $this->nbreExerciceCombine = $nbreExerciceCombine;

        return $this;
    }

    /**
     * Get nbreExerciceCombine
     *
     * @return integer
     */
    public function getNbreExerciceCombine()
    {
        return $this->nbreExerciceCombine;
    }

    /**
     * Set nbreExerciceCmc
     *
     * @param integer $nbreExerciceCmc
     *
     * @return ObjectifKpihse
     */
    public function setNbreExerciceCmc($nbreExerciceCmc)
    {
        $this->nbreExerciceCmc = $nbreExerciceCmc;

        return $this;
    }

    /**
     * Get nbreExerciceCmc
     *
     * @return integer
     */
    public function getNbreExerciceCmc()
    {
        return $this->nbreExerciceCmc;
    }

    /**
     * Set nbreVisiteCodir
     *
     * @param integer $nbreVisiteCodir
     *
     * @return ObjectifKpihse
     */
    public function setNbreVisiteCodir($nbreVisiteCodir)
    {
        $this->nbreVisiteCodir = $nbreVisiteCodir;

        return $this;
    }

    /**
     * Get nbreVisiteCodir
     *
     * @return integer
     */
    public function getNbreVisiteCodir()
    {
        return $this->nbreVisiteCodir;
    }

    /**
     * Set nbreEvenementReporte
     *
     * @param integer $nbreEvenementReporte
     *
     * @return ObjectifKpihse
     */
    public function setNbreEvenementReporte($nbreEvenementReporte)
    {
        $this->nbreEvenementReporte = $nbreEvenementReporte;

        return $this;
    }

    /**
     * Get nbreEvenementReporte
     *
     * @return integer
     */
    public function getNbreEvenementReporte()
    {
        return $this->nbreEvenementReporte;
    }

    /**
     * Set indiceReporting
     *
     * @param string $indiceReporting
     *
     * @return ObjectifKpihse
     */
    public function setIndiceReporting($indiceReporting)
    {
        $this->indiceReporting = $indiceReporting;

        return $this;
    }

    /**
     * Get indiceReporting
     *
     * @return string
     */
    public function getIndiceReporting()
    {
        return $this->indiceReporting;
    }

    /**
     * Set nbrePresqueAccident
     *
     * @param integer $nbrePresqueAccident
     *
     * @return ObjectifKpihse
     */
    public function setNbrePresqueAccident($nbrePresqueAccident)
    {
        $this->nbrePresqueAccident = $nbrePresqueAccident;

        return $this;
    }

    /**
     * Get nbrePresqueAccident
     *
     * @return integer
     */
    public function getNbrePresqueAccident()
    {
        return $this->nbrePresqueAccident;
    }

    /**
     * Set nbreActeSituationDangereuse
     *
     * @param integer $nbreActeSituationDangereuse
     *
     * @return ObjectifKpihse
     */
    public function setNbreActeSituationDangereuse($nbreActeSituationDangereuse)
    {
        $this->nbreActeSituationDangereuse = $nbreActeSituationDangereuse;

        return $this;
    }

    /**
     * Get nbreActeSituationDangereuse
     *
     * @return integer
     */
    public function getNbreActeSituationDangereuse()
    {
        return $this->nbreActeSituationDangereuse;
    }

    /**
     * Set nbreIncidentPotentiel
     *
     * @param integer $nbreIncidentPotentiel
     *
     * @return ObjectifKpihse
     */
    public function setNbreIncidentPotentiel($nbreIncidentPotentiel)
    {
        $this->nbreIncidentPotentiel = $nbreIncidentPotentiel;

        return $this;
    }

    /**
     * Get nbreIncidentPotentiel
     *
     * @return integer
     */
    public function getNbreIncidentPotentiel()
    {
        return $this->nbreIncidentPotentiel;
    }

    /**
     * Set nbreAnalyseArbreCauseRealise
     *
     * @param integer $nbreAnalyseArbreCauseRealise
     *
     * @return ObjectifKpihse
     */
    public function setNbreAnalyseArbreCauseRealise($nbreAnalyseArbreCauseRealise)
    {
        $this->nbreAnalyseArbreCauseRealise = $nbreAnalyseArbreCauseRealise;

        return $this;
    }

    /**
     * Get nbreAnalyseArbreCauseRealise
     *
     * @return integer
     */
    public function getNbreAnalyseArbreCauseRealise()
    {
        return $this->nbreAnalyseArbreCauseRealise;
    }

    /**
     * Set zoneEtancheSup159
     *
     * @param integer $zoneEtancheSup159
     *
     * @return ObjectifKpihse
     */
    public function setZoneEtancheSup159($zoneEtancheSup159)
    {
        $this->zoneEtancheSup159 = $zoneEtancheSup159;

        return $this;
    }

    /**
     * Get zoneEtancheSup159
     *
     * @return integer
     */
    public function getZoneEtancheSup159()
    {
        return $this->zoneEtancheSup159;
    }

    /**
     * Set zoneEtancheInf159
     *
     * @param integer $zoneEtancheInf159
     *
     * @return ObjectifKpihse
     */
    public function setZoneEtancheInf159($zoneEtancheInf159)
    {
        $this->zoneEtancheInf159 = $zoneEtancheInf159;

        return $this;
    }

    /**
     * Get zoneEtancheInf159
     *
     * @return integer
     */
    public function getZoneEtancheInf159()
    {
        return $this->zoneEtancheInf159;
    }

    /**
     * Set zoneNonEtancheSup159
     *
     * @param integer $zoneNonEtancheSup159
     *
     * @return ObjectifKpihse
     */
    public function setZoneNonEtancheSup159($zoneNonEtancheSup159)
    {
        $this->zoneNonEtancheSup159 = $zoneNonEtancheSup159;

        return $this;
    }

    /**
     * Get zoneNonEtancheSup159
     *
     * @return integer
     */
    public function getZoneNonEtancheSup159()
    {
        return $this->zoneNonEtancheSup159;
    }

    /**
     * Set zoneNonEtancheInf159
     *
     * @param integer $zoneNonEtancheInf159
     *
     * @return ObjectifKpihse
     */
    public function setZoneNonEtancheInf159($zoneNonEtancheInf159)
    {
        $this->zoneNonEtancheInf159 = $zoneNonEtancheInf159;

        return $this;
    }

    /**
     * Get zoneNonEtancheInf159
     *
     * @return integer
     */
    public function getZoneNonEtancheInf159()
    {
        return $this->zoneNonEtancheInf159;
    }

    /**
     * Set fuiteProduitNonMesurable
     *
     * @param integer $fuiteProduitNonMesurable
     *
     * @return ObjectifKpihse
     */
    public function setFuiteProduitNonMesurable($fuiteProduitNonMesurable)
    {
        $this->fuiteProduitNonMesurable = $fuiteProduitNonMesurable;

        return $this;
    }

    /**
     * Get fuiteProduitNonMesurable
     *
     * @return integer
     */
    public function getFuiteProduitNonMesurable()
    {
        return $this->fuiteProduitNonMesurable;
    }

    public function getTotalEnvironment(){
        return $this->getFuiteProduitNonMesurable() + $this->getZoneNonEtancheInf159() + $this->getZoneNonEtancheSup159() + $this->getZoneEtancheInf159() + $this->getZoneEtancheSup159();
    }
    
    /**
     * Set pollutionMarine
     *
     * @param integer $pollutionMarine
     *
     * @return ObjectifKpihse
     */
    public function setPollutionMarine($pollutionMarine)
    {
        $this->pollutionMarine = $pollutionMarine;

        return $this;
    }

    /**
     * Get pollutionMarine
     *
     * @return integer
     */
    public function getPollutionMarine()
    {
        return $this->pollutionMarine;
    }

    /**
     * Set piezometreNbEchantillonPreleve
     *
     * @param integer $piezometreNbEchantillonPreleve
     *
     * @return ObjectifKpihse
     */
    public function setPiezometreNbEchantillonPreleve($piezometreNbEchantillonPreleve)
    {
        $this->piezometreNbEchantillonPreleve = $piezometreNbEchantillonPreleve;

        return $this;
    }

    /**
     * Get piezometreNbEchantillonPreleve
     *
     * @return integer
     */
    public function getPiezometreNbEchantillonPreleve()
    {
        return $this->piezometreNbEchantillonPreleve;
    }

    /**
     * Set piezometreNbEchantillonAnalyse
     *
     * @param integer $piezometreNbEchantillonAnalyse
     *
     * @return ObjectifKpihse
     */
    public function setPiezometreNbEchantillonAnalyse($piezometreNbEchantillonAnalyse)
    {
        $this->piezometreNbEchantillonAnalyse = $piezometreNbEchantillonAnalyse;

        return $this;
    }

    /**
     * Get piezometreNbEchantillonAnalyse
     *
     * @return integer
     */
    public function getPiezometreNbEchantillonAnalyse()
    {
        return $this->piezometreNbEchantillonAnalyse;
    }

    /**
     * Set piezometreNbAnomalieReleve
     *
     * @param integer $piezometreNbAnomalieReleve
     *
     * @return ObjectifKpihse
     */
    public function setPiezometreNbAnomalieReleve($piezometreNbAnomalieReleve)
    {
        $this->piezometreNbAnomalieReleve = $piezometreNbAnomalieReleve;

        return $this;
    }

    /**
     * Get piezometreNbAnomalieReleve
     *
     * @return integer
     */
    public function getPiezometreNbAnomalieReleve()
    {
        return $this->piezometreNbAnomalieReleve;
    }

    /**
     * Set piezometreTauxNonConformite
     *
     * @param string $piezometreTauxNonConformite
     *
     * @return ObjectifKpihse
     */
    public function setPiezometreTauxNonConformite($piezometreTauxNonConformite)
    {
        $this->piezometreTauxNonConformite = $piezometreTauxNonConformite;

        return $this;
    }

    /**
     * Get piezometreTauxNonConformite
     *
     * @return string
     */
    public function getPiezometreTauxNonConformite()
    {
        return $this->piezometreTauxNonConformite;
    }

    /**
     * Set decanteurNbEchantillonPreleve
     *
     * @param integer $decanteurNbEchantillonPreleve
     *
     * @return ObjectifKpihse
     */
    public function setDecanteurNbEchantillonPreleve($decanteurNbEchantillonPreleve)
    {
        $this->decanteurNbEchantillonPreleve = $decanteurNbEchantillonPreleve;

        return $this;
    }

    /**
     * Get decanteurNbEchantillonPreleve
     *
     * @return integer
     */
    public function getDecanteurNbEchantillonPreleve()
    {
        return $this->decanteurNbEchantillonPreleve;
    }

    /**
     * Set decanteurNbEchantillonAnalyse
     *
     * @param integer $decanteurNbEchantillonAnalyse
     *
     * @return ObjectifKpihse
     */
    public function setDecanteurNbEchantillonAnalyse($decanteurNbEchantillonAnalyse)
    {
        $this->decanteurNbEchantillonAnalyse = $decanteurNbEchantillonAnalyse;

        return $this;
    }

    /**
     * Get decanteurNbEchantillonAnalyse
     *
     * @return integer
     */
    public function getDecanteurNbEchantillonAnalyse()
    {
        return $this->decanteurNbEchantillonAnalyse;
    }

    /**
     * Set decanteurNbAnomalieReleve
     *
     * @param integer $decanteurNbAnomalieReleve
     *
     * @return ObjectifKpihse
     */
    public function setDecanteurNbAnomalieReleve($decanteurNbAnomalieReleve)
    {
        $this->decanteurNbAnomalieReleve = $decanteurNbAnomalieReleve;

        return $this;
    }

    /**
     * Get decanteurNbAnomalieReleve
     *
     * @return integer
     */
    public function getDecanteurNbAnomalieReleve()
    {
        return $this->decanteurNbAnomalieReleve;
    }

    /**
     * Set decanteurTauxNonConformite
     *
     * @param string $decanteurTauxNonConformite
     *
     * @return ObjectifKpihse
     */
    public function setDecanteurTauxNonConformite($decanteurTauxNonConformite)
    {
        $this->decanteurTauxNonConformite = $decanteurTauxNonConformite;

        return $this;
    }

    /**
     * Get decanteurTauxNonConformite
     *
     * @return string
     */
    public function getDecanteurTauxNonConformite()
    {
        return $this->decanteurTauxNonConformite;
    }

    /**
     * Set laboratoireNbEchantillonPreleve
     *
     * @param integer $laboratoireNbEchantillonPreleve
     *
     * @return ObjectifKpihse
     */
    public function setLaboratoireNbEchantillonPreleve($laboratoireNbEchantillonPreleve)
    {
        $this->laboratoireNbEchantillonPreleve = $laboratoireNbEchantillonPreleve;

        return $this;
    }

    /**
     * Get laboratoireNbEchantillonPreleve
     *
     * @return integer
     */
    public function getLaboratoireNbEchantillonPreleve()
    {
        return $this->laboratoireNbEchantillonPreleve;
    }

    /**
     * Set laboratoireNbEchantillonAnalyse
     *
     * @param integer $laboratoireNbEchantillonAnalyse
     *
     * @return ObjectifKpihse
     */
    public function setLaboratoireNbEchantillonAnalyse($laboratoireNbEchantillonAnalyse)
    {
        $this->laboratoireNbEchantillonAnalyse = $laboratoireNbEchantillonAnalyse;

        return $this;
    }

    /**
     * Get laboratoireNbEchantillonAnalyse
     *
     * @return integer
     */
    public function getLaboratoireNbEchantillonAnalyse()
    {
        return $this->laboratoireNbEchantillonAnalyse;
    }

    /**
     * Set laboratoireNbAnomalieReleve
     *
     * @param integer $laboratoireNbAnomalieReleve
     *
     * @return ObjectifKpihse
     */
    public function setLaboratoireNbAnomalieReleve($laboratoireNbAnomalieReleve)
    {
        $this->laboratoireNbAnomalieReleve = $laboratoireNbAnomalieReleve;

        return $this;
    }

    /**
     * Get laboratoireNbAnomalieReleve
     *
     * @return integer
     */
    public function getLaboratoireNbAnomalieReleve()
    {
        return $this->laboratoireNbAnomalieReleve;
    }

    /**
     * Set laboratoireTauxNonConformite
     *
     * @param string $laboratoireTauxNonConformite
     *
     * @return ObjectifKpihse
     */
    public function setLaboratoireTauxNonConformite($laboratoireTauxNonConformite)
    {
        $this->laboratoireTauxNonConformite = $laboratoireTauxNonConformite;

        return $this;
    }

    /**
     * Get laboratoireTauxNonConformite
     *
     * @return string
     */
    public function getLaboratoireTauxNonConformite()
    {
        return $this->laboratoireTauxNonConformite;
    }

    /**
     * Set laboratoireResultatEssaiCirculaire
     *
     * @param string $laboratoireResultatEssaiCirculaire
     *
     * @return ObjectifKpihse
     */
    public function setLaboratoireResultatEssaiCirculaire($laboratoireResultatEssaiCirculaire)
    {
        $this->laboratoireResultatEssaiCirculaire = $laboratoireResultatEssaiCirculaire;

        return $this;
    }

    /**
     * Get laboratoireResultatEssaiCirculaire
     *
     * @return string
     */
    public function getLaboratoireResultatEssaiCirculaire()
    {
        return $this->laboratoireResultatEssaiCirculaire;
    }

    /**
     * Set nbreNonConformiteCloture
     *
     * @param integer $nbreNonConformiteCloture
     *
     * @return ObjectifKpihse
     */
    public function setNbreNonConformiteCloture($nbreNonConformiteCloture)
    {
        $this->nbreNonConformiteCloture = $nbreNonConformiteCloture;

        return $this;
    }

    /**
     * Get nbreNonConformiteCloture
     *
     * @return integer
     */
    public function getNbreNonConformiteCloture()
    {
        return $this->nbreNonConformiteCloture;
    }

    /**
     * Set nbreNonConformiteNonEchue
     *
     * @param integer $nbreNonConformiteNonEchue
     *
     * @return ObjectifKpihse
     */
    public function setNbreNonConformiteNonEchue($nbreNonConformiteNonEchue)
    {
        $this->nbreNonConformiteNonEchue = $nbreNonConformiteNonEchue;

        return $this;
    }

    /**
     * Get nbreNonConformiteNonEchue
     *
     * @return integer
     */
    public function getNbreNonConformiteNonEchue()
    {
        return $this->nbreNonConformiteNonEchue;
    }

    /**
     * Set nbreOVERDUE
     *
     * @param integer $nbreOVERDUE
     *
     * @return ObjectifKpihse
     */
    public function setNbreOVERDUE($nbreOVERDUE)
    {
        $this->nbreOVERDUE = $nbreOVERDUE;

        return $this;
    }

    /**
     * Get nbreOVERDUE
     *
     * @return integer
     */
    public function getNbreOVERDUE()
    {
        return $this->nbreOVERDUE;
    }

    /**
     * Set pourcentageOVERDUE
     *
     * @param string $pourcentageOVERDUE
     *
     * @return ObjectifKpihse
     */
    public function setPourcentageOVERDUE($pourcentageOVERDUE)
    {
        $this->pourcentageOVERDUE = $pourcentageOVERDUE;

        return $this;
    }

    /**
     * Get pourcentageOVERDUE
     *
     * @return string
     */
    public function getPourcentageOVERDUE()
    {
        return $this->pourcentageOVERDUE;
    }

    public function setDateEnd($dateEnd){
        $this->dateEnd = $dateEnd;
        return $this;
    }

    public function getDateEnd(){
        return $this->dateEnd;
    }

    /**
     * Set toolboxSiege
     *
     * @param integer $toolboxSiege
     *
     * @return ObjectifKpihse
     */
    public function setToolboxSiege($toolboxSiege)
    {
        $this->toolboxSiege = $toolboxSiege;

        return $this;
    }

    /**
     * Get toolboxSiege
     *
     * @return integer
     */
    public function getToolboxSiege()
    {
        return $this->toolboxSiege;
    }

    /**
     * Set toolboxDepot
     *
     * @param integer $toolboxDepot
     *
     * @return ObjectifKpihse
     */
    public function setToolboxDepot($toolboxDepot)
    {
        $this->toolboxDepot = $toolboxDepot;

        return $this;
    }

    /**
     * Get toolboxDepot
     *
     * @return integer
     */
    public function getToolboxDepot()
    {
        return $this->toolboxDepot;
    }

    /**
     * Set toolboxSct
     *
     * @param integer $toolboxSct
     *
     * @return ObjectifKpihse
     */
    public function setToolboxSct($toolboxSct)
    {
        $this->toolboxSct = $toolboxSct;

        return $this;
    }

    /**
     * Get toolboxSct
     *
     * @return integer
     */
    public function getToolboxSct()
    {
        return $this->toolboxSct;
    }
}
