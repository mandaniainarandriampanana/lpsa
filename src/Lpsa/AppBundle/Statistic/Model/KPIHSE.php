<?php

namespace Lpsa\AppBundle\Statistic\Model;

class KPIHSE{

    private $lastYear;

    private $date;

    private $totalFAT = 0;

    private $totalLTI = 0;

    private $totalRWC = 0;

    private $totalMT = 0;

    private $totalFA = 0;

    private $totalAccident = 0;

    private $totalPresquAccident = 0;

    private $totalComportementNonSecuritaire = 0;

    private $totalSituationDangereuse = 0;

    private $totalDysfonctionnementsMateriels = 0;

    //Nbre d'accidents  " Dépots" avec arrêt 
    private $nbLostTimeAccidentRepositories = 0;

    //Nbre d'accidents"Siège" avec arrêt 
    private $nbLostTimeAccidentCenter = 0;

    //Nbre d'accidents  " Dépots"sans arrêt 
    private $nbAccidentRepositories = 0;

    //Nbre d'accidents"Siège" sans arrêt
    private $nbAccidentCenter = 0;

    private $lastCategoryAccident = 0;

    private $lastCategoryIncident = 0;

    private $environmentLess1m3ZE = 0;

    private $environmentMore1m3ZE = 0;

    private $environmentLess1m3ZNE = 0;

    private $environmentMore1m3ZNE = 0;

    private $lastIncident = null;

    private $lastAccident = null;

    private $fat = array(
        'nbLpsa' => 0,
        'nbContracte' => 0,
        'nbTiers' => 0
    );

    private $lti = array(
        'nbLpsa' => 0,
        'nbContracte' => 0
    );

    private $rwc = array(
        'nbLpsa' => 0,
        'nbContracte' => 0
    );

    private $mt = array(
        'nbLpsa' => 0,
        'nbContracte' => 0
    );

    private $fa = array(
        'nbLpsa' => 0,
        'nbContracte' => 0
    );

    private $countCategories = array(
        'totalAccident' => 0,
        'totalPresquAccident' => 0,
        'totalComportementNonSecuritaire' => 0,
        'totalSituationDangereuse' => 0,
        'totalDysfonctionnementsMateriels' => 0
    );

    private $trir = 0;

    private $ltir = 0;

    private $trir12 = 0;

    private $ltir12 = 0;

    private $trirObject = 0;

    private $far = 0;

    private $far12 = 0;

    private $nbTransportTerrestreSansArret = 0;

    private $nbTransportTerrestreAvecArret = 0;

    private $nbTransportMaritimeSansArret = 0;

    private $nbTransportMaritimeAvecArret = 0;

    private $nbAgression = 0;

    private $nbVol = 0;

    private $nbIntrusion = 0;

    private $nbPoi = 0;

    private $nbMiniPoi = 0;

    private $nbPum = 0;

    private $nbCombine = 0;

    private $nbCmc = 0;

    private $toolboxSiege = 0;

    private $toolboxDepots = 0;

    private $toolboxSct = 0;

    private $visite = 0;

    private $piezometreNbEchantillonPreleve = 0;

    private $piezometreNbEchantillonAnalyse = 0;

    private $piezometreNbAnomalieReleve = 0;

    private $piezometreTauxNonConformite = 0;

    private $decanteurNbEchantillonPreleve = 0;

    private $decanteurNbEchantillonAnalyse = 0;

    private $decanteurNbAnomalieReleve = 0;

    private $decanteurTauxNonConformite = 0;

    private $laboratoireNbEchantillonPreleve = 0;

    private $laboratoireNbEchantillonAnalyse = 0;

    private $laboratoireNbAnomalieReleve = 0;

    private $laboratoireTauxNonConformite = 0;

    private $laboratoireResultatEssaiCirculaire = 0;

    private $nbreJourAccidentCorporelTransportRoute = 0;

    private $kmAccidentCorporelTransportRoute = 0;

    private $nbreJourAccidentCorporelTransportRail = 0;

    private $kmAccidentCorporelTransportRail = 0;

    private $nbreJourIncidentTransportMaritime = 0;

    private $kmIncidentTransportMaritime = 0;

    private $nbreJourFatalite = 0;

    private $tauxSinistraliteMatiereDangereuse = 0;

    private $kmVehiculeLeger = 0;

    private $tauxSinistraliteVehiculeLeger = 0;

    private $nbreNonConformiteCloture = 0;

    private $nbreNonConformiteNonEchue = 0;

    private $nbreOVERDUE = 0;

    private $pourcentageOVERDUE = 0;

    private $presqueAccident = 0;

    private $situationDangereuse = 0;

    private $incidentPotentiel = 0;

    private $nbEvenementReporte = 0;

    private $nbLpsaRecap = 0;

    private $nbAnalyseParArbreCauseRealise = 0;

    private $nbFuiteflexible = 0; 

    private $nbTotalPaqssse = 0;

    private $fuiteNonMesurable = 0;

    public function setNbFuiteflexible($nbFuiteflexible){
        $this->nbFuiteflexible = $nbFuiteflexible;
        return $this;
    }

    public function getNbFuiteflexible(){
        return $this->nbFuiteflexible;
    }

    public function setNbParArbreCauseRealise($nbAnalyseParArbreCauseRealise){
        $this->nbAnalyseParArbreCauseRealise = $nbAnalyseParArbreCauseRealise;
        return $this;
    }

    public function getNbParArbreCauseRealise(){
        return $this->nbAnalyseParArbreCauseRealise;
    }

    public function setNbLpsaRecap($nbLpsaRecap){
        $this->nbLpsaRecap = $nbLpsaRecap;
        return $this;
    }

    public function getNbLpsaRecap(){
        return $this->nbLpsaRecap;
    }

    public function getIndiceReporting(){
        if($this->getNbLpsaRecap() === 0){
            return 0;
        }
        return $this->getNbEvenementReporte() * 365 / $this->getNbLpsaRecap();
    }

    public function setNbEvenementReporte($nbEvenementReporte){
        $this->nbEvenementReporte = $nbEvenementReporte;
        return $this;
    }

    public function getNbEvenementReporte(){
        return $this->nbEvenementReporte;
    }

    public function setIncidentPotentiel($incidentPotentiel){
        $this->incidentPotentiel = $incidentPotentiel;
        return $this;
    }

    public function getIncidentPotentiel(){
        return $this->incidentPotentiel;
    }

    public function setPresqueAccident($presqueAccident){
        $this->presqueAccident = $presqueAccident;
        return $this;
    }

    public function getPresqueAccident(){
        return $this->presqueAccident;
    }

    public function setSituationDangereuse($situationDangereuse){
        $this->situationDangereuse = $situationDangereuse;
        return $this;
    }

    public function getSituationDangereuse(){
        return $this->situationDangereuse;
    }

    public function getNumberDaysSinceLastIncident(){
        $now = new \DateTime('now');
        if(!$this->getLastCategoryIncident() || $this->getLastIncident() === null){
            return 0;
        }
        $interval = $now->diff($this->getLastCategoryIncident()->getDateDesFaits());
        if($this->getLastIncident() !== null){
            $interval = $this->getLastIncident()->getDateDesFaits()->diff($this->getLastCategoryIncident()->getDateDesFaits());
        }
        return $interval->format('%a');
    }

    public function getNumberDaysSinceLastAccident(){
        $now = new \DateTime('now');
        if(!$this->getLastCategoryAccident() || $this->getLastAccident() === null){
            return 0;
        }
        $interval = $now->diff($this->getLastCategoryAccident()->getDateDesFaits());
        if($this->getLastAccident() !== null){
            $interval = $this->getLastAccident()->getDateDesFaits()->diff($this->getLastCategoryAccident()->getDateDesFaits());
        }
        return $interval->format('%a');
    }

    public function setLastIncident($lastIncident){
        $this->lastIncident = $lastIncident;
        return $this;
    }

    public function getLastIncident(){
        return $this->lastIncident;
    }

    public function setLastAccident($lastAccident){
        $this->lastAccident = $lastAccident;
        return $this;
    }

    public function getLastAccident(){
        return $this->lastAccident;
    }

    /**
     * Total Recordable Injury
     */
    public function getTRI(){
        return $this->totalMT + $this->totalRWC + $this->totalFAT + $this->totalLTI;
    }

    public function getTotalAccident(){
        return $this->totalAccident;
    }

    public function getTotalPresquAccident(){
        return $this->totalPresquAccident;
    }

    public function getTotalComportementNonSecuritaire(){
        return $this->totalComportementNonSecuritaire;
    }

    public function getTotalSituationDangereuse(){
        return $this->totalSituationDangereuse;
    }

    public function getTotalDysfonctionnementsMateriels(){
        return $this->totalDysfonctionnementsMateriels;
    }

    public function setTotalAccident($totalAccident){
        $this->totalAccident = $totalAccident;
        return $this;
    }

    public function setTotalPresquAccident($totalPresquAccident){
        $this->totalPresquAccident = $totalPresquAccident;
        return $this;
    }

    public function setTotalComportementNonSecuritaire($totalComportementNonSecuritaire){
        $this->totalComportementNonSecuritaire = $totalComportementNonSecuritaire;
        return $this;
    }

    public function setTotalSituationDangereuse($totalSituationDangereuse){
        $this->totalSituationDangereuse = $totalSituationDangereuse;
        return $this;
    }

    public function setTotalDysfonctionnementsMateriels($totalDysfonctionnementsMateriels){
        $this->totalDysfonctionnementsMateriels = $totalDysfonctionnementsMateriels;
        return $this;
    }

    public function setTotalFat($totalFAT){
        $this->totalFAT = $totalFAT;
        return $this;
    }

    public function getTotalFat(){
        return $this->totalFAT;
    }

    public function setTotalLti($totalLTI){
        $this->totalLTI = $totalLTI;
        return $this;
    }

    public function getTotalLti(){
        return $this->totalLTI;
    }

    public function setTotalRwc($totalRWC){
        $this->totalRWC = $totalRWC;
        return $this;
    }

    public function getTotalRwc(){
        return $this->totalRWC;
    }

    public function setTotalMt($totalMT){
        $this->totalMT = $totalMT;
        return $this;
    }

    public function getTotalMt(){
        return $this->totalMT;
    }

    public function setTotalFa($totalFA){
        $this->totalFA = $totalFA;
        return $this;
    }

    public function getTotalFa(){
        return $this->totalFA;
    }

    public function setNbLostTimeAccidentRepositories($nbLostTimeAccidentRepositories){
        $this->nbLostTimeAccidentRepositories = $nbLostTimeAccidentRepositories;
        return $this;
    }

    public function getNbLostTimeAccidentRepositories(){
        return $this->nbLostTimeAccidentRepositories;
    }

    public function setNbLostTimeAccidentCenter($nbLostTimeAccidentCenter){
        $this->nbLostTimeAccidentCenter = $nbLostTimeAccidentCenter;
        return $this;
    }

    public function getNbLostTimeAccidentCenter(){
        return $this->nbLostTimeAccidentCenter;
    }

    public function setNbAccidentRepositories($nbAccidentRepositories){
        $this->nbAccidentRepositories = $nbAccidentRepositories;
        return $this;
    }

    public function getNbAccidentRepositories(){
        return $this->nbAccidentRepositories;
    }

    public function setNbAccidentCenter($nbAccidentCenter){
        $this->nbAccidentCenter = $nbAccidentCenter;
        return $this;
    }

    public function getNbAccidentCenter(){
        return $this->nbAccidentCenter;
    }

    public function setLastCategoryAccident($lastCategoryAccident){
        $this->lastCategoryAccident = $lastCategoryAccident;
        return $this;
    }

    public function getLastCategoryAccident(){
        return $this->lastCategoryAccident;
    }

    public function setLastCategoryIncident($lastCategoryIncident){
        $this->lastCategoryIncident = $lastCategoryIncident;
        return $this;
    }

    public function getLastCategoryIncident(){
        return $this->lastCategoryIncident;
    }

    public function setEnvironmentLess1m3ZE($environmentLess1m3ZE){
        $this->environmentLess1m3ZE = (int) $environmentLess1m3ZE;
        return $this;
    }

    public function getEnvironmentLess1m3ZE(){
        return $this->environmentLess1m3ZE;
    }

    public function setEnvironmentMore1m3ZE($environmentMore1m3ZE){
        $this->environmentMore1m3ZE = (int) $environmentMore1m3ZE;
        return $this;
    }

    public function getEnvironmentMore1m3ZE(){
        return $this->environmentMore1m3ZE;
    }

    public function setEnvironmentLess1m3ZNE($environmentLess1m3ZNE){
        $this->environmentLess1m3ZNE = (int) $environmentLess1m3ZNE;
        return $this;
    }

    public function getEnvironmentLess1m3ZNE(){
        return $this->environmentLess1m3ZNE;
    }

    public function setEnvironmentMore1m3ZNE($environmentMore1m3ZNE){
        $this->environmentMore1m3ZNE = (int) $environmentMore1m3ZNE;
        return $this;
    }

    public function getEnvironmentMore1m3ZNE(){
        return $this->environmentMore1m3ZNE;
    }

    public function getTotalEnvironment(){
        return $this->getEnvironmentLess1m3ZE() + $this->getEnvironmentMore1m3ZE() + $this->getEnvironmentLess1m3ZNE() + $this->getEnvironmentMore1m3ZNE() + $this->getFuiteNonMesurable();
    }

    public function setFat($fat){
        $this->fat = $fat;
        return $this;
    }

    public function getFat(){
        return $this->fat;
    }

    public function setLti($lti){
        $this->lti = $lti;
        return $this;
    }

    public function getLti(){
        return $this->lti;
    }

    public function setRwc($rwc){
        $this->rwc = $rwc;
        return $this;
    }

    public function getRwc(){
        return $this->rwc;
    }

    public function setMt($mt){
        $this->mt = $mt;
        return $this;
    }

    public function getMt(){
        return $this->mt;
    }

    public function setFa($fa){
        $this->fa = $fa;
        return $this;
    }

    public function getFa(){
        return $this->fa;
    }

    public function setCountCategories($countCategories){
        $this->countCategories = $countCategories;
        $this->setTotalAccident($countCategories['totalAccident']);
        $this->setTotalPresquAccident($countCategories['totalPresquAccident']);
        $this->setTotalComportementNonSecuritaire($countCategories['totalComportementNonSecuritaire']);
        $this->setTotalSituationDangereuse($countCategories['totalSituationDangereuse']);
        $this->setTotalDysfonctionnementsMateriels($countCategories['totalDysfonctionnementsMateriels']);
        return $this;
    }

    public function getCountCategories(){
        return $this->countCategories;
    }

    public function setLastYear($lastYear){
        $this->lastYear = $lastYear;
        return $this;
    }

    public function getLastYear(){
        return $this->lastYear;
    }

    public function setDate($date){
        $this->date = $date;
        return $this;
    }

    public function getDate(){
        return $this->date;
    }
    
    public function setTrirObject($trir){
        $this->trirObject = $trir;
        return $this;
    }

    public function getTrirObject(){
        return $this->trirObject;
    }

    public function setFar($far){
        $this->far = $far;
        return $this;
    }
    
    public function getFar(){
        return $this->far;
    }

    public function setFar12($far){
        $this->far12 = $far;
        return $this;
    }
    
    public function getFar12(){
        return $this->far12;
    }

    public function setTrir($trir){
        $this->trir = $trir;
        return $this;
    }

    public function getTrir(){
        return $this->trir;
    }

    public function setLtir($ltir){
        $this->ltir = $ltir;
        return $this;
    }

    public function getLtir(){
        return $this->ltir;
    }

    public function setTrir12($trir){
        $this->trir12 = $trir;
        return $this;
    }

    public function getTrir12(){
        return $this->trir12;
    }

    public function setLtir12($ltir){
        $this->ltir12 = $ltir;
        return $this;
    }

    public function getLtir12(){
        return $this->ltir12;
    }

    public function setNbTransportTerrestreSansArret($nbTransportTerrestreSansArret){
        $this->nbTransportTerrestreSansArret = $nbTransportTerrestreSansArret;
        return $this;
    }

    public function getNbTransportTerrestreSansArret(){
        return $this->nbTransportTerrestreSansArret;
    }

    public function setNbTransportTerrestreAvecArret($nbTransportTerrestreAvecArret){
        $this->nbTransportTerrestreAvecArret = $nbTransportTerrestreAvecArret;
        return $this;
    }

    public function getNbTransportTerrestreAvecArret(){
        return $this->nbTransportTerrestreAvecArret;
    }

    public function setNbTransportMaritimeSansArret($nbTransportMaritimeSansArret){
        $this->nbTransportMaritimeSansArret = $nbTransportMaritimeSansArret;
        return $this;
    }

    public function getNbTransportMaritimeSansArret(){
        return $this->nbTransportMaritimeSansArret;
    }

    public function setNbTransportMaritimeAvecArret($nbTransportMaritimeAvecArret){
        $this->nbTransportMaritimeAvecArret = $nbTransportMaritimeAvecArret;
        return $this;
    }

    public function getNbTransportMaritimeAvecArret(){
        return $this->nbTransportMaritimeAvecArret;
    }

    public function getCumulSansArret(){
        return $this->getNbAccidentCenter() + $this->getNbAccidentRepositories() + $this->getNbTransportMaritimeSansArret() + $this->getNbTransportTerrestreSansArret();
    }

    public function getCumulAvecArret(){
        return $this->getNbLostTimeAccidentCenter() + $this->getNbLostTimeAccidentRepositories() + $this->getNbTransportTerrestreAvecArret() + $this->getNbTransportMaritimeAvecArret();
    }

    public function setNbVol($nbVol){
        $this->nbVol = $nbVol;
        return $this;
    }
     
    public function getNbVol(){
        return $this->nbVol;
    }

    public function setNbAgression($nbAgression){
        $this->nbAgression = $nbAgression;
        return $this;
    }

    public function getNbAgression(){
        return $this->nbAgression;
    }

    public function setNbIntrusion($nbIntrusion){
        $this->nbIntrusion = $nbIntrusion;
        return $this;
    }

    public function getNbIntrusion(){
        return $this->nbIntrusion;
    }

    public function setNbPoi($nbPoi){
        $this->nbPoi = $nbPoi;
        return $this;
    }

    public function getNbPoi(){
        return $this->nbPoi;
    }

    public function setNbMiniPoi($nbMiniPoi){
        $this->nbMiniPoi = $nbMiniPoi;
        return $this;
    }

    public function getNbMiniPoi(){
        return $this->nbMiniPoi;
    }

    public function setNbPum($nbPum){
        $this->nbPum = $nbPum;
        return $this;
    }

    public function getNbPum(){
        return $this->nbPum;
    }

    public function setNbCombine($nbCombine){
        $this->nbCombine = $nbCombine;
        return $this;
    }

    public function getNbCombine(){
        return $this->nbCombine;
    }

    public function setNbCmc($nbCmc){
        $this->nbCmc = $nbCmc;
        return $this;
    }

    public function getNbCmc(){
        return $this->nbCmc;
    }

    public function setToolboxSiege($toolboxSiege){
        $this->toolboxSiege = $toolboxSiege;
        return $this;
    }

    public function getToolboxSiege(){
        return $this->toolboxSiege;
    }

    public function setToolboxDepots($toolboxDepots){
        $this->toolboxDepots = $toolboxDepots;
        return $this;
    }

    public function getToolboxDepots(){
        return $this->toolboxDepots;
    }

    public function setToolboxSct($toolboxSct){
        $this->toolboxSct = $toolboxSct;
        return $this;
    }

    public function getToolboxSct(){
        return $this->toolboxSct;
    }

    public function setVisite($visite){
        $this->visite = $visite;
        return $this;
    }

    public function getVisite(){
        return $this->visite;
    }

    public function setPiezometreNbEchantillonPreleve($piezometreNbEchantillonPreleve){
        $this->piezometreNbEchantillonPreleve = $piezometreNbEchantillonPreleve;
        return $this;
    }

    public function getPiezometreNbEchantillonPreleve(){
        return $this->piezometreNbEchantillonPreleve;
    }

    public function setPiezometreNbEchantillonAnalyse($piezometreNbEchantillonAnalyse){
        $this->piezometreNbEchantillonAnalyse = $piezometreNbEchantillonAnalyse;
        return $this;
    }

    public function getPiezometreNbEchantillonAnalyse(){
        return $this->piezometreNbEchantillonAnalyse;
    }

    public function setPiezometreNbAnomalieReleve($piezometreNbAnomalieReleve){
        $this->piezometreNbAnomalieReleve = $piezometreNbAnomalieReleve;
        return $this;
    }

    public function getPiezometreNbAnomalieReleve(){
        return $this->piezometreNbAnomalieReleve;
    }

    public function setPiezometreTauxNonConformite($piezometreTauxNonConformite){
        $this->piezometreTauxNonConformite = $piezometreTauxNonConformite;
        return $this;
    }

    public function getPiezometreTauxNonConformite(){
        return $this->piezometreTauxNonConformite;
    }

    public function setDecanteurNbEchantillonPreleve($decanteurNbEchantillonPreleve){
        $this->decanteurNbEchantillonPreleve = $decanteurNbEchantillonPreleve;
        return $this;
    }

    public function getDecanteurNbEchantillonPreleve(){
        return $this->decanteurNbEchantillonPreleve;
    }

    public function setDecanteurNbEchantillonAnalyse($decanteurNbEchantillonAnalyse){
        $this->decanteurNbEchantillonAnalyse = $decanteurNbEchantillonAnalyse;
        return $this;
    }

    public function getDecanteurNbEchantillonAnalyse(){
        return $this->decanteurNbEchantillonAnalyse;
    }

    public function setDecanteurNbAnomalieReleve($decanteurNbAnomalieReleve){
        $this->decanteurNbAnomalieReleve = $decanteurNbAnomalieReleve;
        return $this;
    }

    public function getDecanteurNbAnomalieReleve(){
        return $this->decanteurNbAnomalieReleve;
    }

    public function setDecanteurTauxNonConformite($decanteurTauxNonConformite){
        $this->decanteurTauxNonConformite = $decanteurTauxNonConformite;
        return $this;
    }

    public function getDecanteurTauxNonConformite(){
        return $this->decanteurTauxNonConformite;
    }
    
    public function setLaboratoireNbEchantillonPreleve($laboratoireNbEchantillonPreleve){
        $this->laboratoireNbEchantillonPreleve = $laboratoireNbEchantillonPreleve;
        return $this;
    }

    public function getLaboratoireNbEchantillonPreleve(){
        return $this->laboratoireNbEchantillonPreleve;
    }

    public function setLaboratoireNbEchantillonAnalyse($laboratoireNbEchantillonAnalyse){
        $this->laboratoireNbEchantillonAnalyse = $laboratoireNbEchantillonAnalyse;
        return $this;
    }

    public function getLaboratoireNbEchantillonAnalyse(){
        return $this->laboratoireNbEchantillonAnalyse;
    }

    public function setLaboratoireNbAnomalieReleve($laboratoireNbAnomalieReleve){
        $this->laboratoireNbAnomalieReleve = $laboratoireNbAnomalieReleve;
        return $this;
    }

    public function getLaboratoireNbAnomalieReleve(){
        return $this->laboratoireNbAnomalieReleve;
    }

    public function setLaboratoireTauxNonConformite($laboratoireTauxNonConformite){
        $this->laboratoireTauxNonConformite = $laboratoireTauxNonConformite;
        return $this;
    }

    public function getLaboratoireTauxNonConformite(){
        //return $this->laboratoireTauxNonConformite;
        if($this->getLaboratoireNbEchantillonAnalyse() > 0){
            return (float) ($this->getLaboratoireNbAnomalieReleve() / $this->getLaboratoireNbEchantillonAnalyse()) * 100;
        }
        return 0;
    }

    public function setLaboratoireResultatEssaiCirculaire($laboratoireResultatEssaiCirculaire){
        $this->laboratoireResultatEssaiCirculaire = $laboratoireResultatEssaiCirculaire;
        return $this;
    }

    public function getLaboratoireResultatEssaiCirculaire(){
        return $this->laboratoireResultatEssaiCirculaire;
    }

    public function setNbreJourAccidentCorporelTransportRoute($nbreJourAccidentCorporelTransportRoute)
    {
        $this->nbreJourAccidentCorporelTransportRoute = $nbreJourAccidentCorporelTransportRoute;
        return $this;
    }

    public function getNbreJourAccidentCorporelTransportRoute()
    {
        return $this->nbreJourAccidentCorporelTransportRoute;
    }

    public function setKmAccidentCorporelTransportRoute($kmAccidentCorporelTransportRoute)
    {
        $this->kmAccidentCorporelTransportRoute = $kmAccidentCorporelTransportRoute;
        return $this;
    }

    public function getKmAccidentCorporelTransportRoute()
    {
        return $this->kmAccidentCorporelTransportRoute;
    }

    public function setNbreJourAccidentCorporelTransportRail($nbreJourAccidentCorporelTransportRail)
    {
        $this->nbreJourAccidentCorporelTransportRail = $nbreJourAccidentCorporelTransportRail;
        return $this;
    }

    public function getNbreJourAccidentCorporelTransportRail()
    {
        return $this->nbreJourAccidentCorporelTransportRail;
    }

    public function setKmAccidentCorporelTransportRail($kmAccidentCorporelTransportRail)
    {
        $this->kmAccidentCorporelTransportRail = $kmAccidentCorporelTransportRail;
        return $this;
    }

    public function getKmAccidentCorporelTransportRail()
    {
        return $this->kmAccidentCorporelTransportRail;
    }

    public function setNbreJourIncidentTransportMaritime($nbreJourIncidentTransportMaritime)
    {
        $this->nbreJourIncidentTransportMaritime = $nbreJourIncidentTransportMaritime;
        return $this;
    }

    public function getNbreJourIncidentTransportMaritime()
    {
        return $this->nbreJourIncidentTransportMaritime;
    }

    public function setKmIncidentTransportMaritime($kmIncidentTransportMaritime)
    {
        $this->kmIncidentTransportMaritime = $kmIncidentTransportMaritime;
        return $this;
    }

    public function getKmIncidentTransportMaritime()
    {
        return $this->kmIncidentTransportMaritime;
    }

    public function setNbreJourFatalite($nbreJourFatalite)
    {
        $this->nbreJourFatalite = $nbreJourFatalite;
        return $this;
    }

    public function getNbreJourFatalite()
    {
        return $this->nbreJourFatalite;
    }

    public function setTauxSinistraliteMatiereDangereuse($tauxSinistraliteMatiereDangereuse)
    {
        $this->tauxSinistraliteMatiereDangereuse = $tauxSinistraliteMatiereDangereuse;
        return $this;
    }

    public function getTauxSinistraliteMatiereDangereuse()
    {
        return $this->tauxSinistraliteMatiereDangereuse;
    }

    public function setKmVehiculeLeger($kmVehiculeLeger)
    {
        $this->kmVehiculeLeger = $kmVehiculeLeger;
        return $this;
    }

    public function getKmVehiculeLeger()
    {
        return $this->kmVehiculeLeger;
    }

    public function setTauxSinistraliteVehiculeLeger($tauxSinistraliteVehiculeLeger)
    {
        $this->tauxSinistraliteVehiculeLeger = $tauxSinistraliteVehiculeLeger;
        return $this;
    }

    public function getTauxSinistraliteVehiculeLeger()
    {
        return $this->tauxSinistraliteVehiculeLeger;
    }

    public function setNbreNonConformiteCloture($nbreNonConformiteCloture)
    {
        $this->nbreNonConformiteCloture = $nbreNonConformiteCloture;
        return $this;
    }

    public function getNbreNonConformiteCloture()
    {
        return $this->nbreNonConformiteCloture;
    }

    public function setNbreNonConformiteNonEchue($nbreNonConformiteNonEchue)
    {
        $this->nbreNonConformiteNonEchue = $nbreNonConformiteNonEchue;
        return $this;
    }

    public function getNbreNonConformiteNonEchue()
    {
        return $this->nbreNonConformiteNonEchue;
    }

    public function setNbreOVERDUE($nbreOVERDUE)
    {
        $this->nbreOVERDUE = $nbreOVERDUE;
        return $this;
    }

    public function getNbreOVERDUE()
    {
        return $this->nbreOVERDUE;
    }

    public function setPourcentageOVERDUE($pourcentageOVERDUE)
    {
        $this->pourcentageOVERDUE = $pourcentageOVERDUE;
        return $this;
    }

    public function getPourcentageOVERDUE()
    {
        if($this->getNbTotalPaqssse() === 0){
            return 0;
        }
        return  ($this->getNbreOVERDUE()/$this->getNbTotalPaqssse()) * 100;
    }

    public function setNbTotalPaqssse($nbTotalPaqssse)
    {        
        $this->nbTotalPaqssse = $nbTotalPaqssse;
        return $this;
    }

    public function getNbTotalPaqssse()
    {
        return $this->nbTotalPaqssse;
    }

    public function setFuiteNonMesurable($fuiteNonMesurable)
    {
        $this->fuiteNonMesurable = $fuiteNonMesurable;

        return $this;
    }

    public function getFuiteNonMesurable()
    {
        return $this->fuiteNonMesurable;
    }
}