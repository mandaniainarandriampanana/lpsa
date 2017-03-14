<?php

namespace Lpsa\AppBundle\Statistic;


use Doctrine\ORM\EntityManager;
use Lpsa\AppBundle\Entity\Manager\EvenementManager;
use Lpsa\AppBundle\Statistic\Model\KPIHSE;
use Lpsa\AppBundle\Statistic\Model\LTIR;
use Lpsa\AppBundle\Statistic\Model\TRIR;
use Lpsa\AppBundle\Statistic\Model\ObjectifKpihse;
use Lpsa\AppBundle\Statistic\StatisticLtirTrir;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class StatisticKPIHSE extends StatisticDataBinding{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EvenementManager
     */
    protected $eventManager;

    private $aKPIHSE = array();

    private $environmentEvents;

    private $corporelEvents;

    private $categorieEvents;

    private $depotCategorieEvents;

    private $monthHeaders = array();

    private $dateEnd = null;

    private $dateStart = null;

    private $statisticLtirTrir;

    private $exerciceUrgences;

    private $toolbox;

    private $visites;

    private $piezometres;

    private $decanteurs;

    private $laboratoires;

    private $indicateurTransports;

    private $PAQSSSEs;

    private $fuiteProduits;
    
    private $nbUsers;

    /**
     *
     * @var Container 
     */
    protected $container;

    /* construct.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em,EvenementManager $eventManager, StatisticLtirTrir $statisticLtirTrir, Container $container)
    {
        $this->em = $em;
        $this->eventManager = $eventManager; 
        $this->statisticLtirTrir = $statisticLtirTrir;  
        $this->container = $container;
        $this->setLpsaUsers();     
    }

    public function setLpsaUsers(){
        $userManager = $this->container->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        $count = 0;
        foreach($users as $user){
            $groups = $user->getGroups();
            foreach($groups as $group){
                $dep = $group->getDepot();
                if($dep){
                   $count++;
                   break;
                }
            }
        }
        $this->nbUsers = $count;
    }

    private function initDefaultDateStart(){
        $now = new \DateTime('now');
        if($this->dateStart === null){
            $lastYear = $now->modify('-1 year');
            $this->dateStart = new \DateTime($lastYear->format('Y') . '-12-' . self::MONTH_DAY_START);
        }
        return $this->dateStart;
    }

    private function initDefaultDateEnd(){
        $now = new \DateTime('now');
        if($this->dateEnd === null){
            $this->dateEnd = new \DateTime($now->format('Y') . '-12-' . self::MONTH_DAY_END);
        }
        return $this->dateEnd;
    }

    //Environment events
    private function fetchEnvironmentEvents($dateStart,$dateEnd){
        $this->environmentEvents = $this->eventManager->getRepository()->findWithEnvironmentByDate($dateStart,$dateEnd);
        return $this;
    }

    //Corporel events
    private function fetchCorporelEvents($dateStart,$dateEnd){
        $this->corporelEvents = $this->eventManager->getRepository()->findWithCorporelByDate($dateStart,$dateEnd);
        return $this;
    }

    //Categorie events
    private function fetchCategorieEvents($dateStart,$dateEnd){
        $this->categorieEvents = $this->eventManager->getRepository()->findWithCategorieByDate($dateStart,$dateEnd);
        return $this;
    }

    //DepotCategorie events
    private function fetchDepotCategorieEvents($dateStart,$dateEnd){        
        $this->depotCategorieEvents = $this->eventManager->getRepository()->findWithDepotCategorieByDate($dateStart,$dateEnd);
        return $this;
    }

    //ExerciceUrgence
    private function fetchExerciceUrgences($dateEnd){        
        $this->exerciceUrgences = $this->em->getRepository('LpsaAppBundle:ExerciceUrgence')->findAllByYear($dateEnd->format('Y'));
        return $this;
    }

    //Toolbox
    private function fetchToolbox($dateEnd){        
        $this->toolbox = $this->em->getRepository('LpsaAppBundle:Toolbox')->findAllByYear($dateEnd->format('Y'));
        return $this;
    }

    //Visite
    private function fetchVisite($dateEnd){        
        $this->visites = $this->em->getRepository('LpsaAppBundle:Visite')->findAllByYear($dateEnd->format('Y'));
        return $this;
    }

    //Piezometre
    private function fetchPiezometre($dateEnd){        
        $this->piezometres = $this->em->getRepository('LpsaAppBundle:Piezometre')->findAllByYear($dateEnd->format('Y'));
        return $this;
    }

    //Decanteur
    private function fetchDecanteur($dateEnd){        
        $this->decanteurs = $this->em->getRepository('LpsaAppBundle:Decanteur')->findAllByYear($dateEnd->format('Y'));
        return $this;
    }

    //Laboratoire
    private function fetchLaboratoire($dateEnd){        
        $this->laboratoires = $this->em->getRepository('LpsaAppBundle:Laboratoire')->findAllByYear($dateEnd->format('Y'));
        return $this;
    }

    //Indicateur Transport
    private function fetchIndicateurTransport($dateEnd){        
        $this->indicateurTransports = $this->em->getRepository('LpsaAppBundle:IndicateurTransport')->findAllByYear($dateEnd->format('Y'));
        return $this;
    }

    //PAQSSSE
    private function fetchPAQSSSE($dateStart,$dateEnd){        
        $this->PAQSSSEs = $this->eventManager->getRepository()->findAllPaqssse($dateStart,$dateEnd);
        return $this;
    }

    //Fuite produit
    private function fetchFuiteProduit($dateEnd){        
        $this->fuiteProduits = $this->em->getRepository('LpsaAppBundle:FuiteProduit')->findAllByYear($dateEnd->format('Y'));
        return $this;
    }

    private function prepareData(){
        $limit = intval($this->dateEnd->format('m'));
        $start = intval($this->dateStart->format('m'));
        $year = intval($this->dateEnd->format('Y'));
        if($start > 11){
            $start = 1;
        }
        //init kpihse for 1 year
        for($month = $start;$month <= $limit; $month++){
            $this->aKPIHSE[$month] = new KPIHSE();
            $this->monthHeaders[] = new \DateTime($year . "-$month-" . self::MONTH_DAY_START);
        }
        //prepare LTIR-TRIR
        $this->statisticLtirTrir->process($this->dateStart,$this->dateEnd);

        // go step by step
        $this->countEventsWithCorporelRelationship()
             ->countEventsWithDepotCategorieRelationship()
             ->countEventsWithCategorieRelationship();
        //LTIR-TRIR
        $this->setTrirLtir();
        //Exercice urgence
        $this->setExerciceUrgence();
        //Toolbox
        $this->setToolbox();
        //Visite
        $this->setVisite();
        //Piezomètre
        $this->setPiezometre();
        //Decanteur
        $this->setDecanteur();
        //Laboratoire
        $this->setLaboratoire();
        //Epandages
        $this->setEpandages();
        //IndicateurTransport
        $this->setIndicateurTransport();
        //PAQSSSE
        $this->setPAQSSSE();
        //Fuite produit
        $this->setFuiteProduit();
    }

    private function setExerciceUrgence(){
        $ordered = $this->orderedByMonth($this->exerciceUrgences);
        foreach($this->aKPIHSE as $month => $kpihse){
            $nbPoi = $nbMiniPoi = $nbPum = $nbCombine = $nbCmc = 0;
            if(array_key_exists($month,$ordered)){
                foreach($ordered[$month] as $value){
                    $nbPoi += $value->getNbrePoi();
                    $nbMiniPoi += $value->getNbreMiniPoi();
                    $nbPum += $value->getNbrePum();
                    $nbCombine += $value->getNbreCombine();
                    $nbCmc += $value->getNbreCmc();
                }
            }
            $kpihse->setNbPoi($nbPoi)
                   ->setNbMiniPoi($nbMiniPoi)
                   ->setNbCombine($nbCombine)
                   ->setNbCmc($nbCmc)
                   ->setNbPum($nbPum)
            ;
        }
    }

    private function setToolbox(){
        $ordered = $this->orderedByMonth($this->toolbox);
        foreach($this->aKPIHSE as $month => $kpihse){
            $toolboxSiege = $toolboxDepots = $toolboxSct = 0;
            if(array_key_exists($month,$ordered)){
                foreach($ordered[$month] as $value){
                    $toolboxSiege += $value->getSiege();
                    $toolboxDepots += $value->getDepots();
                    $toolboxSct += $value->getSct();
                }
            }
            $kpihse->setToolboxSiege($toolboxSiege)
                   ->setToolboxDepots($toolboxDepots)
                   ->setToolboxSct($toolboxSct)
            ;
        }
    }

    private function setVisite(){
        $ordered = $this->orderedByMonth($this->visites);
        foreach($this->aKPIHSE as $month => $kpihse){
            $visite = 0;
            if(array_key_exists($month,$ordered)){
                foreach($ordered[$month] as $value){
                    $visite += $value->getNbreVisite();
                }
            }
            $kpihse->setVisite($visite)
            ;
        }
    }

    private function setPiezometre(){
        $ordered = $this->orderedByMonth($this->piezometres);
        foreach($this->aKPIHSE as $month => $kpihse){
            $piezometreNbEchantillonPreleve = $piezometreNbEchantillonAnalyse = $piezometreNbAnomalieReleve = $piezometreTauxNonConformite = 0;
            if(array_key_exists($month,$ordered)){
                foreach($ordered[$month] as $value){
                    $piezometreNbEchantillonPreleve += $value->getNbreEchantillonPreleve();
                    $piezometreNbEchantillonAnalyse += $value->getNbreEchantillonAnalyse();
                    $piezometreNbAnomalieReleve += $value->getNbreAnomalieReleve();
                    $piezometreTauxNonConformite += (float) $value->getTauxNonConformite();
                }
            }
            $kpihse->setPiezometreNbEchantillonPreleve($piezometreNbEchantillonPreleve)
                   ->setPiezometreNbEchantillonAnalyse($piezometreNbEchantillonAnalyse)
                   ->setPiezometreNbAnomalieReleve($piezometreNbAnomalieReleve)
                   ->setPiezometreTauxNonConformite($piezometreTauxNonConformite)
            ;
        }
    }

    private function setDecanteur(){
        $ordered = $this->orderedByMonth($this->decanteurs);
        foreach($this->aKPIHSE as $month => $kpihse){
            $decanteurNbEchantillonPreleve = $decanteurNbEchantillonAnalyse = $decanteurNbAnomalieReleve = $decanteurTauxNonConformite = 0;
            if(array_key_exists($month,$ordered)){
                foreach($ordered[$month] as $value){
                    $decanteurNbEchantillonPreleve += $value->getNbreEchantillonPreleve();
                    $decanteurNbEchantillonAnalyse += $value->getNbreEchantillonAnalyse();
                    $decanteurNbAnomalieReleve += $value->getNbreAnomalieReleve();
                    $decanteurTauxNonConformite += (float) $value->getTauxNonConformite();
                }
            }
            $kpihse->setDecanteurNbEchantillonPreleve($decanteurNbEchantillonPreleve)
                   ->setDecanteurNbEchantillonAnalyse($decanteurNbEchantillonAnalyse)
                   ->setDecanteurNbAnomalieReleve($decanteurNbAnomalieReleve)
                   ->setDecanteurTauxNonConformite($decanteurTauxNonConformite)
            ;
        }
    }

    private function setLaboratoire(){
        $ordered = $this->orderedByMonth($this->laboratoires);
        foreach($this->aKPIHSE as $month => $kpihse){
            $laboratoireResultatEssaiCirculaire = $laboratoireNbEchantillonPreleve = $laboratoireNbEchantillonAnalyse = $laboratoireNbAnomalieReleve = $laboratoireTauxNonConformite = 0;
            if(array_key_exists($month,$ordered)){
                foreach($ordered[$month] as $value){
                    $laboratoireNbEchantillonPreleve += $value->getNbreEchantillonPreleve();
                    $laboratoireNbEchantillonAnalyse += $value->getNbreEchantillonAnalyse();
                    $laboratoireNbAnomalieReleve += $value->getNbreAnomalieReleve();
                    $laboratoireResultatEssaiCirculaire += (float) $value->getResultatEssaiCirculaire();
                }
            }
            $kpihse->setLaboratoireNbEchantillonPreleve($laboratoireNbEchantillonPreleve)
                   ->setLaboratoireNbEchantillonAnalyse($laboratoireNbEchantillonAnalyse)
                   ->setLaboratoireNbAnomalieReleve($laboratoireNbAnomalieReleve)
                   ->setLaboratoireResultatEssaiCirculaire($laboratoireResultatEssaiCirculaire)
            ;
        }
    }

    private function setEpandages(){
        $orderedEvents = array();
        foreach($this->environmentEvents as $event){
            $date = $event->getDateEmission();
            $day = intval($date->format('d'));
            $month = intval($date->format('m'));
            if($day > self::MONTH_DAY_END){
                $month++;//increment month
            } 
            $orderedEvents[$month][] = $event;
        }
        ksort($orderedEvents);
        foreach($this->aKPIHSE as $month => $kpihse){
            $environmentLess1m3ZE = $environmentMore1m3ZE = $environmentLess1m3ZNE = $environmentMore1m3ZNE = 0;
            $nbFuiteflexible = 0; 
            if(array_key_exists($month,$orderedEvents)){
                foreach($orderedEvents[$month] as $event){
                    $environment = $event->getEnvironnement();
                    if($environment && ($environment->getTypeEnvironnement()->getId() === self::ZONE_ETANCHE) && ($environment->getId() === self::ENVIRONMENT_ZE_LESS_1_M3)){
                        $environmentLess1m3ZE++;
                    }
                    if($environment && ($environment->getTypeEnvironnement()->getId() === self::ZONE_ETANCHE) && ($environment->getId() !== self::ENVIRONMENT_ZE_LESS_1_M3)){
                        $environmentMore1m3ZE++;
                    }
                    if($environment && ($environment->getTypeEnvironnement()->getId() === self::ZONE_NON_ETANCHE) && ($environment->getId() === self::ENVIRONMENT_ZNE_LESS_1_M3)){
                        $environmentLess1m3ZNE++;
                    }
                    if($environment && ($environment->getTypeEnvironnement()->getId() === self::ZONE_NON_ETANCHE) && ($environment->getId() !== self::ENVIRONMENT_ZNE_LESS_1_M3)){
                        $environmentMore1m3ZNE++;
                    }
                    if($environment && in_array($environment->getId(),$this->fuiteflexibleIds)){
                        $nbFuiteflexible++;
                    }
                }
            }
            $kpihse->setEnvironmentLess1m3ZE($environmentLess1m3ZE)
                   ->setEnvironmentMore1m3ZE($environmentMore1m3ZE)
                   ->setEnvironmentLess1m3ZNE($environmentLess1m3ZNE)
                   ->setEnvironmentMore1m3ZNE($environmentMore1m3ZNE)
                   ->setNbFuiteflexible($nbFuiteflexible)
            ;
        }
    }

    private function setIndicateurTransport(){
        $ordered = $this->orderedByMonth($this->indicateurTransports);
        foreach($this->aKPIHSE as $month => $kpihse){
            $nbreJourAccidentCorporelTransportRoute = $kmAccidentCorporelTransportRoute = $nbreJourAccidentCorporelTransportRail = $kmAccidentCorporelTransportRail = 0;
            $nbreJourIncidentTransportMaritime = $kmIncidentTransportMaritime = $nbreJourFatalite = $tauxSinistraliteMatiereDangereuse = 0;
            $kmVehiculeLeger = $tauxSinistraliteVehiculeLeger = 0;
            if(array_key_exists($month,$ordered)){
                foreach($ordered[$month] as $value){
                    $nbreJourAccidentCorporelTransportRoute += (float) $value->getNbreJourAccidentCorporelTransportRoute();
                    $kmAccidentCorporelTransportRoute += (float) $value->getKmAccidentCorporelTransportRoute();
                    $nbreJourAccidentCorporelTransportRail += (float) $value->getNbreJourAccidentCorporelTransportRail();
                    $kmAccidentCorporelTransportRail += (float) $value->getKmAccidentCorporelTransportRail();
                    $nbreJourIncidentTransportMaritime += (float) $value->getNbreJourIncidentTransportMaritime();
                    $kmIncidentTransportMaritime += (float) $value->getKmIncidentTransportMaritime();
                    $nbreJourFatalite += (float) $value->getNbreJourFatalite();
                    $tauxSinistraliteMatiereDangereuse += (float) $value->getTauxSinistraliteMatiereDangereuse();
                    $kmVehiculeLeger += (float) $value->getKmVehiculeLeger();
                    $tauxSinistraliteVehiculeLeger += (float) $value->getTauxSinistraliteVehiculeLeger();
                }
            }
            $kpihse->setNbreJourAccidentCorporelTransportRoute($nbreJourAccidentCorporelTransportRoute)
                   ->setKmAccidentCorporelTransportRoute($kmAccidentCorporelTransportRoute)
                   ->setNbreJourAccidentCorporelTransportRail($nbreJourAccidentCorporelTransportRail)
                   ->setKmAccidentCorporelTransportRail($kmAccidentCorporelTransportRail)
                   ->setNbreJourIncidentTransportMaritime($nbreJourIncidentTransportMaritime)
                   ->setKmIncidentTransportMaritime($kmIncidentTransportMaritime)
                   ->setNbreJourFatalite($nbreJourFatalite)
                   ->setTauxSinistraliteMatiereDangereuse($tauxSinistraliteMatiereDangereuse)
                   ->setKmVehiculeLeger($kmVehiculeLeger)
                   ->setTauxSinistraliteVehiculeLeger($tauxSinistraliteVehiculeLeger)
            ;
        }
    }

    private function setFuiteProduit(){
        $ordered = $this->orderedByMonth($this->fuiteProduits);
        foreach($this->aKPIHSE as $month => $kpihse){
            $fuiteNonMesurable = 0;
            if(array_key_exists($month,$ordered)){
                foreach($ordered[$month] as $value){
                    $fuiteNonMesurable += $value->getFuiteNonMesurable();
                }
            }
            $kpihse->setFuiteNonMesurable($fuiteNonMesurable)
            ;
        }
    }

    private function setPAQSSSE(){
        $orderedEvents = array();
        foreach($this->PAQSSSEs as $event){
            $date = $event->getDateEmission();
            $day = intval($date->format('d'));
            $month = intval($date->format('m'));
            if($day > self::MONTH_DAY_END){
                $month++;//increment month
            } 
            $orderedEvents[$month][] = $event;
        }
        ksort($orderedEvents);
        foreach($this->aKPIHSE as $month => $kpihse){
            $nbreNonConformiteCloture = $nbreNonConformiteNonEchue = $nbreOVERDUE = $pourcentageOVERDUE = 0;
            $nbPaqssse = 0;
            if(array_key_exists($month,$orderedEvents)){
                foreach($orderedEvents[$month] as $value){
                    $paq3se = $value->getPaq3se();
                    if($paq3se && $paq3se->getDateFin()){
                        $nbPaqssse++;
                        $now = new \DateTime('now');
                        $diff = $now->diff($paq3se->getDateFin());
                        if($diff->days === 0 && ($value->getEvenementStatut() === self::STATUT_NON_CLOTURE)){
                            $nbreNonConformiteNonEchue++;
                        }
                        if($value->getEvenementStatut() === self::STATUT_NON_CLOTURE){
                            $nbreNonConformiteCloture++;
                        } 
                        if($diff->days > 0){
                            $nbreOVERDUE++;
                        }
                    }
                }
                if($nbPaqssse > 0){
                    $pourcentageOVERDUE = ($nbreOVERDUE/$nbPaqssse) * 100;
                }
            }
            $kpihse->setNbreNonConformiteCloture($nbreNonConformiteCloture)
                   ->setNbreNonConformiteNonEchue($nbreNonConformiteNonEchue)
                   ->setNbreOVERDUE($nbreOVERDUE)
                   ->setNbTotalPaqssse($nbPaqssse)
            ;
        }
    }

    private function orderedByMonth($data){
        $newData = array();
        if(empty($data)){
            return $newData;
        }
        reset($data);
        $this->environmentEvents;
        $last = current($data);
        $tmp = array();
        foreach($data as $key => $value){
            $environmentLess1m3ZE = $environmentMore1m3ZE = $environmentLess1m3ZNE = $environmentMore1m3ZNE = 0;
            if($last->getMois() !== $value->getMois()){
                $newData[$last->getMois()] = $tmp;
                $tmp = array();
            }
            $tmp[] = $value;
            if(($key === count($data) - 1)){
                $newData[$value->getMois()] = $tmp;
            }
            $last = $value;
        }
        ksort($newData);
        return $newData;
    }

    private function setTrirLtir(){        
        $trir = $this->statisticLtirTrir->getTRIR();
        $ltir = $this->statisticLtirTrir->getLTIR();
        foreach($this->aKPIHSE as $month => $kpihse){
            if(array_key_exists($month,$ltir)){
                $kpihse->setLtir($ltir[$month]->getLTIR())
                       ->setTrir($trir[$month]->getTRIR())
                       ->setTrirObject($trir[$month])
                       ->setLtir12($ltir[$month]->get12MonthsLTIR($month))
                       ->setTrir12($trir[$month]->get12MonthsTRIR($month))
                       ->setFar12($trir[$month]->get12MonthsFar($month))
                ;
            }
        } 
        return $this;
    }

    private function countEventsWithCorporelRelationship(){
        $orderedEvents = array();
        foreach($this->corporelEvents as $event){
            $date = $event->getDateEmission();
            $day = intval($date->format('d'));
            $month = intval($date->format('m'));
            if($day > self::MONTH_DAY_END){
                $month++;//increment month
            } 
            $orderedEvents[$month][] = $event;
        }
        ksort($orderedEvents);
        foreach($this->aKPIHSE as $month => $kpihse){
            $fat = array('nbLpsa' => 0,'nbContracte' => 0,'nbTiers' => 0);
            $lti = array('nbLpsa' => 0,'nbContracte' => 0);
            $rwc = array('nbLpsa' => 0,'nbContracte' => 0);
            $mt = array('nbLpsa' => 0,'nbContracte' => 0);
            $fa = array('nbLpsa' => 0,'nbContracte' => 0);
            $nbLostTimeAccidentRepositories = 0;
            $nbAccidentRepositories = 0;
            $nbLpsaRecap = 0;//Recap année pour personnel lpsa
            if(array_key_exists($month,$orderedEvents)){
                $events = $orderedEvents[$month];
                foreach($events as $event){
                    $corporel = $event->getCorporel();
                    $nbLpsaRecap += $event->getNbreLpsa();    
                    if($corporel && ($corporel->getTypeCorporel()->getId() === self::FAT)){
                        if($event->getNbreLpsa()){
                            $fat['nbLpsa'] = $fat['nbLpsa'] + $event->getNbreLpsa();               
                        }
                        if($event->getNbreContracte()){
                            $fat['nbContracte'] = $fat['nbContracte'] + $event->getNbreContracte();               
                        }
                        if($event->getNbreTiers()){
                            $fat['nbTiers'] = $fat['nbTiers'] + $event->getNbreTiers();               
                        }
                    }
                    if($corporel && ($corporel->getTypeCorporel()->getId() === self::LTI)){
                        if($event->getNbreLpsa()){
                            $lti['nbLpsa'] = $lti['nbLpsa'] + $event->getNbreLpsa();               
                        }
                        if($event->getNbreContracte()){
                            $lti['nbContracte'] = $lti['nbContracte'] + $event->getNbreContracte();               
                        }
                    }
                    if($corporel && ($corporel->getId() === self::RWC)){
                        if($event->getNbreLpsa()){
                            $rwc['nbLpsa'] = $rwc['nbLpsa'] + $event->getNbreLpsa();               
                        }
                        if($event->getNbreContracte()){
                            $rwc['nbContracte'] = $rwc['nbContracte'] + $event->getNbreContracte();               
                        }
                    }
                    if($corporel && ($corporel->getId() === self::MT)){
                        if($event->getNbreLpsa()){
                            $mt['nbLpsa'] = $mt['nbLpsa'] + $event->getNbreLpsa();               
                        }
                        if($event->getNbreContracte()){
                            $mt['nbContracte'] = $mt['nbContracte'] + $event->getNbreContracte();               
                        }
                    }
                    if($corporel && ($corporel->getTypeCorporel()->getId() === self::LTI) && (in_array($event->getCorporel()->getId(),$this->nbAvecArret))){
                        if($event->getNbreLpsa()){
                            $nbLostTimeAccidentRepositories += $event->getNbreLpsa();               
                        }
                        if($event->getNbreContracte()){
                            $nbLostTimeAccidentRepositories += $event->getNbreContracte();               
                        }
                        if($event->getNbreTiers()){
                            $nbLostTimeAccidentRepositories += $event->getNbreTiers();               
                        }
                    }
                    if($corporel && ($corporel->getTypeCorporel()->getId() === self::ACCIDENT_NON_STOP) && in_array($corporel->getId(),$this->nbAvecArret)){
                        if($event->getNbreLpsa()){
                            $nbAccidentRepositories += $event->getNbreLpsa();               
                        }
                        if($event->getNbreContracte()){
                            $nbAccidentRepositories += $event->getNbreContracte();               
                        }
                        if($event->getNbreTiers()){
                            $nbAccidentRepositories += $event->getNbreTiers();               
                        }
                    }
                    if($corporel && ($corporel->getId() === self::FA)){
                        if($event->getNbreLpsa()){
                            $fa['nbLpsa'] = $fa['nbLpsa'] + $event->getNbreLpsa();               
                        }
                        if($event->getNbreContracte()){
                            $fa['nbContracte'] = $fa['nbContracte'] + $event->getNbreContracte();               
                        }
                    }
                }
            }
            $kpihse->setFat($fat)
               ->setTotalFat($fat['nbLpsa'] + $fat['nbContracte'] + $fat['nbTiers'])
               ->setLti($lti)
               ->setTotalLti($lti['nbLpsa'] + $lti['nbContracte'])
               ->setRwc($rwc)
               ->setTotalRwc($rwc['nbLpsa'] + $rwc['nbContracte'])
               ->setMt($mt)
               ->setTotalMt($mt['nbLpsa'] + $mt['nbContracte'])
               ->setFa($fa)
               ->setTotalFa($fa['nbLpsa'] + $fa['nbContracte'])
               ->setNbLostTimeAccidentRepositories($nbLostTimeAccidentRepositories)
               ->setNbAccidentRepositories($nbAccidentRepositories)
               ->setNbLpsaRecap($this->nbUsers)
               ;
        }
        return $this;
    }

    private function countEventsWithCategorieRelationship(){
        $orderedEvents = array();
        foreach($this->categorieEvents as $event){
            $date = $event->getDateEmission();
            $day = intval($date->format('d'));
            $month = intval($date->format('m'));
            if($day > self::MONTH_DAY_END){
                $month++;//increment month
            } 
            $orderedEvents[$month][] = $event;
        }
        ksort($orderedEvents);
        $categoriesId = $this->container->getParameter('categories_id');
        foreach($this->aKPIHSE as $month => $kpihse){
            $nbTransportTerrestreSansArret = 0;
            $nbTransportTerrestreAvecArret = 0;
            $nbTransportMaritimeSansArret = 0;
            $nbTransportMaritimeAvecArret = 0;
            $nbAgression = $nbVol = $nbIntrusion = 0;
            $presqueAccident = 0;
            $situationDangereuse = 0;
            $incidentPotentiel = 0;
            $nbEvenementReporte = 0;
            $nbAnalyseParArbreCauseRealise = 0;
            if(array_key_exists($month,$orderedEvents)){
                $nbEvenementReporte++;
                $events = $orderedEvents[$month];
                foreach($events as $event){
                    $corporel = $event->getCorporel();
                    $typeAccident = $event->getTypeAccident();
                    //Nombre de Presqu'Accidents (PA)
                    if($event->getCategorie()->getId() === self::PRESQUE_ACCIDENT){
                        $presqueAccident++;
                    }
                    //Situation dangereuse
                    if($event->getCategorie()->getId() === self::SITUATION_DANGEREUSE){
                        $situationDangereuse++;
                    }
                    //Incident potentiel
                    if($event->getGravite() && (int)$event->getGravite()->getValeur() > self::INCIDENT_POTENTIEL){
                        $incidentPotentiel++;
                        $nbAnalyseParArbreCauseRealise++;
                    }
                    //accident: transport maritime/terrestre
                    if($event->getCategorie()->getId() === $categoriesId['accident'] && $corporel && $typeAccident){
                        //avec arrêt
                        if($corporel->getTypeCorporel()->getId() === self::LTI){
                            if($typeAccident->getId() === $this->typeAccident['maritime']){
                                $nbTransportMaritimeAvecArret++;
                            }
                            if($typeAccident->getId() === $this->typeAccident['terrestre']){
                                $nbTransportTerrestreAvecArret++;
                            }                                                     
                        }
                        //sans arrêt
                        if($corporel->getTypeCorporel()->getId() === self::ACCIDENT_NON_STOP){
                            if($typeAccident->getId() === $this->typeAccident['maritime']){
                                $nbTransportMaritimeSansArret++;
                            }
                            if($typeAccident->getId() === $this->typeAccident['terrestre']){
                                $nbTransportTerrestreSansArret++;
                            }     
                        }                        
                    }
                    $typeSituationDangereuse = $event->getTypeSituationDangereuse();
                    if($event->getCategorie()->getId() === $categoriesId['situation_dangereuse'] && $typeSituationDangereuse){
                        if($typeSituationDangereuse->getId() === $this->typeSituationDangereuse['agression']){
                            $nbAgression++;
                        }
                        if($typeSituationDangereuse->getId() === $this->typeSituationDangereuse['vol']){
                            $nbVol++;
                        }
                        if($typeSituationDangereuse->getId() === $this->typeSituationDangereuse['intrusion']){
                            $nbIntrusion++;
                        }    
                    }
                }
            }
            $kpihse->setNbTransportTerrestreSansArret($nbTransportTerrestreSansArret)
                   ->setNbTransportTerrestreAvecArret($nbTransportTerrestreAvecArret)
                   ->setNbTransportMaritimeSansArret($nbTransportMaritimeSansArret)
                   ->setNbTransportMaritimeAvecArret($nbTransportMaritimeAvecArret)
                   ->setNbVol($nbVol)
                   ->setNbAgression($nbAgression)
                   ->setNbIntrusion($nbIntrusion)
                   ->setPresqueAccident($presqueAccident)
                   ->setSituationDangereuse($situationDangereuse)
                   ->setIncidentPotentiel($incidentPotentiel)
                   ->setNbEvenementReporte($nbEvenementReporte)
                   ->setNbParArbreCauseRealise($nbAnalyseParArbreCauseRealise)
                   ;
        }
        return $this;
    }

    private function countEventsWithDepotCategorieRelationship(){
        $orderedEvents = array();
        foreach($this->depotCategorieEvents as $event){
            $date = $event->getDateEmission();
            $day = intval($date->format('d'));
            $month = intval($date->format('m'));
            if($day > self::MONTH_DAY_END){
                $month++;//increment month
            } 
            $orderedEvents[$month][] = $event;
        }
        ksort($orderedEvents);
        foreach($this->aKPIHSE as $month => $kpihse){
            $nbAccidentCenter = 0;
            $nbLostTimeAccidentCenter = 0;            
            if(array_key_exists($month,$orderedEvents)){
                $events = $orderedEvents[$month];
                foreach($events as $event){
                    $corporel = $event->getCorporel();
                    //Nbre d'accidents "Siège" sans arrêt
                    if($corporel && ($event->getDepot()->getDepotCategories()->getId() === self::DEPOT_SIEGE) && ($corporel->getTypeCorporel()->getId() === self::ACCIDENT_NON_STOP) && in_array($corporel->getId(),$this->nbAvecArret)){
                        if($event->getNbreLpsa()){
                            $nbAccidentCenter += $event->getNbreLpsa();               
                        }
                        if($event->getNbreContracte()){
                            $nbAccidentCenter += $event->getNbreContracte();               
                        }
                        if($event->getNbreTiers()){
                            $nbAccidentCenter += $event->getNbreTiers();               
                        }
                    }
                    //Nbre d'accidents "Siège" sans arrêt
                    if(($event->getDepot()->getDepotCategories()->getId() === self::DEPOT_SIEGE) && ($event->getCorporel()->getTypeCorporel()->getId() === self::LTI) && (in_array($event->getId(),$this->nbAvecArret))){
                        if($event->getNbreLpsa()){
                            $nbLostTimeAccidentCenter += $event->getNbreLpsa();               
                        }
                        if($event->getNbreContracte()){
                            $nbLostTimeAccidentCenter += $event->getNbreContracte();               
                        }
                        if($event->getNbreTiers()){
                            $nbLostTimeAccidentCenter += $event->getNbreTiers();               
                        }
                    }
                }
            }
            $kpihse->setNbAccidentCenter($nbAccidentCenter)
                   ->setNbLostTimeAccidentCenter($nbLostTimeAccidentCenter);
        }
        return $this;
    }

    public function process($dateStart = null,$dateEnd = null){
        if($dateStart === null){
            $dateStart = $this->initDefaultDateStart();
        }
        if($dateEnd === null){
            $dateEnd = $this->initDefaultDateEnd();            
        }
        $this->dateEnd = $dateEnd;
        $this->dateStart = $dateStart;
        $this->fetchEnvironmentEvents($dateStart,$dateEnd)
             ->fetchCorporelEvents($dateStart,$dateEnd)
             ->fetchCategorieEvents($dateStart,$dateEnd)
             ->fetchDepotCategorieEvents($dateStart,$dateEnd)
             ->fetchExerciceUrgences($dateEnd)
             ->fetchToolbox($dateEnd)
             ->fetchVisite($dateEnd)
             ->fetchPiezometre($dateEnd)
             ->fetchDecanteur($dateEnd)
             ->fetchLaboratoire($dateEnd)
             ->fetchIndicateurTransport($dateEnd)
             ->fetchPAQSSSE($dateStart,$dateEnd)
             ->fetchFuiteProduit($dateEnd)
             ->prepareData()
             ;
    }

    public function getMonthHeaders(){
        return $this->monthHeaders;
    }

    public function getKPIHSE(){
        return $this->aKPIHSE;
    }

    public function getCurrentCumul(){
        $fat = array('nbLpsa' => 0,'nbContracte' => 0,'nbTiers' => 0);
        $lti = array('nbLpsa' => 0,'nbContracte' => 0);
        $rwc = array('nbLpsa' => 0,'nbContracte' => 0);
        $mt = array('nbLpsa' => 0,'nbContracte' => 0);
        $fa = array('nbLpsa' => 0,'nbContracte' => 0);
        $nbLostTimeAccidentRepositories = 0;
        $nbAccidentRepositories = 0;
        $nbAccidentCenter = 0;
        $nbLostTimeAccidentCenter = 0;
        $trir = $ltir = $trir12 = $ltir12 = 0;
        $nbTransportTerrestreSansArret = 0;
        $nbTransportTerrestreAvecArret = 0;
        $nbTransportMaritimeSansArret = 0;
        $nbTransportMaritimeAvecArret = 0;
        $nbAgression = $nbVol = $nbIntrusion = 0;
        $nbPoi = $nbMiniPoi = $nbPum = $nbCombine = $nbCmc = 0;
        $toolboxSiege = $toolboxDepots = $toolboxSct = $visite = 0;
        $piezometreNbEchantillonPreleve = $piezometreNbEchantillonAnalyse = $piezometreNbAnomalieReleve = $piezometreTauxNonConformite = 0;
        $decanteurNbEchantillonPreleve = $decanteurNbEchantillonAnalyse = $decanteurNbAnomalieReleve = $decanteurTauxNonConformite = 0;
        $laboratoireResultatEssaiCirculaire = $laboratoireNbEchantillonPreleve = $laboratoireNbEchantillonAnalyse = $laboratoireNbAnomalieReleve = $laboratoireTauxNonConformite = 0;
        $environmentLess1m3ZE = $environmentMore1m3ZE = $environmentLess1m3ZNE = $environmentMore1m3ZNE = 0;
        $nbreJourAccidentCorporelTransportRoute = $kmAccidentCorporelTransportRoute = $nbreJourAccidentCorporelTransportRail = $kmAccidentCorporelTransportRail = 0;
        $nbreJourIncidentTransportMaritime = $kmIncidentTransportMaritime = $nbreJourFatalite = $tauxSinistraliteMatiereDangereuse = 0;
        $kmVehiculeLeger = $tauxSinistraliteVehiculeLeger = 0;
        $nbreNonConformiteCloture = $nbreNonConformiteNonEchue = $nbreOVERDUE = $pourcentageOVERDUE = 0;
        $far = $far12 = 0;
        $presqueAccident = 0;
        $situationDangereuse = 0;
        $incidentPotentiel = 0;
        $nbEvenementReporte = 0;
        $nbLpsaRecap = 0;
        $nbAnalyseParArbreCauseRealise = 0;
        $nbFuiteflexible = 0; 
        $nbTotalPaqssse = 0;
        $fuiteNonMesurable = 0;
        foreach($this->aKPIHSE as $month => $kpihse){
            $fatKpi = $kpihse->getFat();
            $fat['nbLpsa'] = $fat['nbLpsa'] + $fatKpi['nbLpsa']; 
            $fat['nbContracte'] = $fat['nbContracte'] + $fatKpi['nbContracte']; 
            $fat['nbTiers'] = $fat['nbTiers'] + $fatKpi['nbTiers']; 
            $ltiKpi = $kpihse->getLti();
            $lti['nbLpsa'] = $lti['nbLpsa'] + $ltiKpi['nbLpsa'];
            $lti['nbContracte'] = $lti['nbContracte'] + $ltiKpi['nbContracte']; 
            $rwcKpi = $kpihse->getRwc();
            $rwc['nbLpsa'] = $rwc['nbLpsa'] + $rwcKpi['nbLpsa'];
            $rwc['nbContracte'] = $rwc['nbContracte'] + $rwcKpi['nbContracte']; 
            $mtKpi = $kpihse->getMt();
            $mt['nbLpsa'] = $mt['nbLpsa'] + $mtKpi['nbLpsa']; 
            $mt['nbContracte'] = $mt['nbContracte'] + $mtKpi['nbContracte']; 
            $nbLostTimeAccidentRepositories += $kpihse->getNbLostTimeAccidentRepositories(); 
            $nbAccidentRepositories += $kpihse->getNbAccidentRepositories(); 
            $faKpi = $kpihse->getFa();
            $fa['nbLpsa'] = $fa['nbLpsa'] + $faKpi['nbLpsa'];  
            $fa['nbContracte'] = $fa['nbContracte'] + $faKpi['nbContracte']; 
            $nbAccidentCenter += $kpihse->getNbAccidentCenter();//Nbre d'accidents "Siège" sans arrêt
            $nbLostTimeAccidentCenter += $kpihse->getNbLostTimeAccidentCenter();//Nbre d'accidents "Siège" sans arrêt
            $trir += $kpihse->getTrir();
            $ltir += $kpihse->getLtir();
            $trir12 += $kpihse->getTrir12();
            $ltir12 += $kpihse->getLtir12();
            $nbTransportTerrestreSansArret += $kpihse->getNbTransportTerrestreSansArret();
            $nbTransportTerrestreAvecArret += $kpihse->getNbTransportTerrestreAvecArret();
            $nbTransportMaritimeSansArret += $kpihse->getNbTransportMaritimeSansArret();
            $nbTransportMaritimeAvecArret += $kpihse->getNbTransportMaritimeAvecArret();
            $nbAgression += $kpihse->getNbAgression();
            $nbVol += $kpihse->getNbVol(); 
            $nbIntrusion += $kpihse->getNbIntrusion();
            $nbPoi += $kpihse->getNbPoi();
            $nbMiniPoi += $kpihse->getNbMiniPoi(); 
            $nbPum += $kpihse->getNbPum(); 
            $nbCombine += $kpihse->getNbCombine();
            $nbCmc += $kpihse->getNbCmc();
            $toolboxSiege += $kpihse->getToolboxSiege(); 
            $toolboxDepots += $kpihse->getToolboxDepots();
            $toolboxSct += $kpihse->getToolboxSct();
            $visite += $kpihse->getVisite();
            $piezometreNbEchantillonPreleve += $kpihse->getPiezometreNbEchantillonPreleve();
            $piezometreNbEchantillonAnalyse += $kpihse->getPiezometreNbEchantillonAnalyse();
            $piezometreNbAnomalieReleve += $kpihse->getPiezometreNbAnomalieReleve();
            $piezometreTauxNonConformite += (float) $kpihse->getPiezometreTauxNonConformite();
            $decanteurNbEchantillonPreleve += $kpihse->getDecanteurNbEchantillonPreleve();
            $decanteurNbEchantillonAnalyse += $kpihse->getDecanteurNbEchantillonAnalyse();
            $decanteurNbAnomalieReleve += $kpihse->getDecanteurNbAnomalieReleve();
            $decanteurTauxNonConformite += (float) $kpihse->getDecanteurTauxNonConformite();
            $laboratoireNbEchantillonPreleve += $kpihse->getLaboratoireNbEchantillonPreleve();
            $laboratoireNbEchantillonAnalyse += $kpihse->getLaboratoireNbEchantillonAnalyse();
            $laboratoireNbAnomalieReleve += $kpihse->getLaboratoireNbAnomalieReleve();
            $laboratoireResultatEssaiCirculaire += (float) $kpihse->getLaboratoireResultatEssaiCirculaire();
            $environmentLess1m3ZE += $kpihse->getEnvironmentLess1m3ZE();
            $environmentMore1m3ZE += $kpihse->getEnvironmentMore1m3ZE();
            $environmentLess1m3ZNE += $kpihse->getEnvironmentLess1m3ZNE();
            $environmentMore1m3ZNE += $kpihse->getEnvironmentMore1m3ZNE();
            $nbreJourAccidentCorporelTransportRoute += (float) $kpihse->getNbreJourAccidentCorporelTransportRoute();
            $kmAccidentCorporelTransportRoute += (float) $kpihse->getKmAccidentCorporelTransportRoute();
            $nbreJourAccidentCorporelTransportRail += (float) $kpihse->getNbreJourAccidentCorporelTransportRail();
            $kmAccidentCorporelTransportRail += (float) $kpihse->getKmAccidentCorporelTransportRail();
            $nbreJourIncidentTransportMaritime += (float) $kpihse->getNbreJourIncidentTransportMaritime();
            $kmIncidentTransportMaritime += (float) $kpihse->getKmIncidentTransportMaritime();
            $nbreJourFatalite += (float) $kpihse->getNbreJourFatalite();
            $tauxSinistraliteMatiereDangereuse += (float) $kpihse->getTauxSinistraliteMatiereDangereuse();
            $kmVehiculeLeger += (float) $kpihse->getKmVehiculeLeger();
            $tauxSinistraliteVehiculeLeger += (float) $kpihse->getTauxSinistraliteVehiculeLeger();
            $nbreNonConformiteCloture += $kpihse->getNbreNonConformiteCloture();
            $nbreNonConformiteNonEchue += $kpihse->getNbreNonConformiteNonEchue();
            $nbreOVERDUE += $kpihse->getNbreOVERDUE();
            $nbTotalPaqssse += $kpihse->getNbTotalPaqssse();
            $far += $kpihse->getTrirObject()->getFar();
            $far12 += $kpihse->getFar12();
            $presqueAccident += $kpihse->getPresqueAccident();
            $situationDangereuse += $kpihse->getSituationDangereuse();
            $incidentPotentiel += $kpihse->getIncidentPotentiel();
            $nbEvenementReporte += $kpihse->getNbEvenementReporte();
            $nbLpsaRecap += $kpihse->getNbLpsaRecap();
            $nbAnalyseParArbreCauseRealise += $kpihse->getNbParArbreCauseRealise();
            $nbFuiteflexible += $kpihse->getNbFuiteflexible(); 
            $fuiteNonMesurable += $kpihse->getFuiteNonMesurable(); 
        }
        if($laboratoireNbEchantillonAnalyse > 0){
            $laboratoireTauxNonConformite = (float) ($laboratoireNbAnomalieReleve / $laboratoireNbEchantillonAnalyse) * 100;
        }
        
        $oTrir = new TRIR();
        $oTrir->setFar($far);
        $kpihse = new KPIHSE();
        $kpihse->setFat($fat)
               ->setTotalFat($fat['nbLpsa'] + $fat['nbContracte'] + $fat['nbTiers'])
               ->setLti($lti)
               ->setTotalLti($lti['nbLpsa'] + $lti['nbContracte'])
               ->setRwc($rwc)
               ->setTotalRwc($rwc['nbLpsa'] + $rwc['nbContracte'])
               ->setMt($mt)
               ->setTotalMt($mt['nbLpsa'] + $mt['nbContracte'])
               ->setFa($fa)
               ->setTotalFa($fa['nbLpsa'] + $fa['nbContracte'])
               ->setNbLostTimeAccidentRepositories($nbLostTimeAccidentRepositories)
               ->setNbAccidentRepositories($nbAccidentRepositories)
               ->setNbAccidentCenter($nbAccidentCenter)
               ->setNbLostTimeAccidentCenter($nbLostTimeAccidentCenter)
               ->setLtir($ltir)
               ->setTrir($trir)
               ->setLtir12($ltir12)
               ->setTrir12($trir12)
               ->setNbTransportTerrestreSansArret($nbTransportTerrestreSansArret)
               ->setNbTransportTerrestreAvecArret($nbTransportTerrestreAvecArret)
               ->setNbTransportMaritimeSansArret($nbTransportMaritimeSansArret)
               ->setNbTransportMaritimeAvecArret($nbTransportMaritimeAvecArret)
               ->setDate($this->dateEnd)
               ->setNbVol($nbVol)
               ->setNbAgression($nbAgression)
               ->setNbIntrusion($nbIntrusion)
               ->setNbPoi($nbPoi)
               ->setNbMiniPoi($nbMiniPoi)
               ->setNbCombine($nbCombine)
               ->setNbCmc($nbCmc)
               ->setNbPum($nbPum)
               ->setToolboxSiege($toolboxSiege)
               ->setToolboxDepots($toolboxDepots)
               ->setToolboxSct($toolboxSct)
               ->setVisite($visite)
               ->setPiezometreNbEchantillonPreleve($piezometreNbEchantillonPreleve)
               ->setPiezometreNbEchantillonAnalyse($piezometreNbEchantillonAnalyse)
               ->setPiezometreNbAnomalieReleve($piezometreNbAnomalieReleve)
               ->setPiezometreTauxNonConformite($piezometreTauxNonConformite)
               ->setDecanteurNbEchantillonPreleve($decanteurNbEchantillonPreleve)
               ->setDecanteurNbEchantillonAnalyse($decanteurNbEchantillonAnalyse)
               ->setDecanteurNbAnomalieReleve($decanteurNbAnomalieReleve)
               ->setDecanteurTauxNonConformite($decanteurTauxNonConformite)
               ->setLaboratoireNbEchantillonPreleve($laboratoireNbEchantillonPreleve)
               ->setLaboratoireNbEchantillonAnalyse($laboratoireNbEchantillonAnalyse)
               ->setLaboratoireNbAnomalieReleve($laboratoireNbAnomalieReleve)
               ->setLaboratoireResultatEssaiCirculaire($laboratoireResultatEssaiCirculaire)
               ->setEnvironmentLess1m3ZE($environmentLess1m3ZE)
               ->setEnvironmentMore1m3ZE($environmentMore1m3ZE)
               ->setEnvironmentLess1m3ZNE($environmentLess1m3ZNE)
               ->setEnvironmentMore1m3ZNE($environmentMore1m3ZNE)
               ->setNbreJourAccidentCorporelTransportRoute($nbreJourAccidentCorporelTransportRoute)
               ->setKmAccidentCorporelTransportRoute($kmAccidentCorporelTransportRoute)
               ->setNbreJourAccidentCorporelTransportRail($nbreJourAccidentCorporelTransportRail)
               ->setKmAccidentCorporelTransportRail($kmAccidentCorporelTransportRail)
               ->setNbreJourIncidentTransportMaritime($nbreJourIncidentTransportMaritime)
               ->setKmIncidentTransportMaritime($kmIncidentTransportMaritime)
               ->setNbreJourFatalite($nbreJourFatalite)
               ->setTauxSinistraliteMatiereDangereuse($tauxSinistraliteMatiereDangereuse)
               ->setKmVehiculeLeger($kmVehiculeLeger)
               ->setTauxSinistraliteVehiculeLeger($tauxSinistraliteVehiculeLeger)
               ->setNbreNonConformiteCloture($nbreNonConformiteCloture)
               ->setNbreNonConformiteNonEchue($nbreNonConformiteNonEchue)
               ->setNbreOVERDUE($nbreOVERDUE)
               ->setNbTotalPaqssse($nbTotalPaqssse)
               ->setTrirObject($oTrir)
               ->setFar12($far12)
               ->setPresqueAccident($presqueAccident)
               ->setSituationDangereuse($situationDangereuse)
               ->setIncidentPotentiel($incidentPotentiel)
               ->setNbEvenementReporte($nbEvenementReporte)
               ->setNbLpsaRecap($this->nbUsers)
               ->setNbParArbreCauseRealise($nbAnalyseParArbreCauseRealise)
               ->setNbFuiteflexible($nbFuiteflexible)
               ->setFuiteNonMesurable($fuiteNonMesurable)
                ;
            ;
        return $kpihse;
    }

    public function getLatestCumul(){
        $currentYear = intval($this->dateEnd->format('Y')) - 1;
        $lastYear = $currentYear - 1;
        $dateStart = new \DateTime($lastYear . '-12-' . self::MONTH_DAY_START);
        $dateEnd = new \DateTime($currentYear . '-12-' . self::MONTH_DAY_END);
        $corporelEvents = $this->eventManager->getRepository()->findWithCorporelByDate($dateStart,$dateEnd);
        $depotCategorieEvents = $this->eventManager->getRepository()->findWithDepotCategorieByDate($dateStart,$dateEnd);
        $categorieEvents = $this->eventManager->getRepository()->findWithCategorieByDate($dateStart,$dateEnd);
        $fat = array('nbLpsa' => 0,'nbContracte' => 0,'nbTiers' => 0);
        $lti = array('nbLpsa' => 0,'nbContracte' => 0);
        $rwc = array('nbLpsa' => 0,'nbContracte' => 0);
        $mt = array('nbLpsa' => 0,'nbContracte' => 0);
        $fa = array('nbLpsa' => 0,'nbContracte' => 0);
        $nbLostTimeAccidentRepositories = 0;
        $nbAccidentRepositories = 0;
        $nbAccidentCenter = 0;
        $nbLostTimeAccidentCenter = 0;
        $nbTransportTerrestreSansArret = 0;
        $nbTransportTerrestreAvecArret = 0;
        $nbTransportMaritimeSansArret = 0;
        $nbTransportMaritimeAvecArret = 0;
        $nbEvenementReporte = 0;
        $nbLpsaRecap = 0;        
        foreach($corporelEvents as $event){
            $corporel = $event->getCorporel();
            $nbLpsaRecap += $event->getNbreLpsa(); 
            if($corporel && ($corporel->getTypeCorporel()->getId() === self::FAT)){
                if($event->getNbreLpsa()){
                    $fat['nbLpsa'] = $fat['nbLpsa'] + $event->getNbreLpsa();               
                }
                if($event->getNbreContracte()){
                    $fat['nbContracte'] = $fat['nbContracte'] + $event->getNbreContracte();               
                }
                if($event->getNbreTiers()){
                    $fat['nbTiers'] = $fat['nbTiers'] + $event->getNbreTiers();               
                }
            }
            if($corporel && ($corporel->getTypeCorporel()->getId() === self::LTI)){
                if($event->getNbreLpsa()){
                    $lti['nbLpsa'] = $lti['nbLpsa'] + $event->getNbreLpsa();               
                }
                if($event->getNbreContracte()){
                    $lti['nbContracte'] = $lti['nbContracte'] + $event->getNbreContracte();               
                }
            }
            if($corporel && ($corporel->getId() === self::RWC)){
                if($event->getNbreLpsa()){
                    $rwc['nbLpsa'] = $rwc['nbLpsa'] + $event->getNbreLpsa();               
                }
                if($event->getNbreContracte()){
                    $rwc['nbContracte'] = $rwc['nbContracte'] + $event->getNbreContracte();               
                }
            }
            if($corporel && ($corporel->getId() === self::MT)){
                if($event->getNbreLpsa()){
                    $mt['nbLpsa'] = $mt['nbLpsa'] + $event->getNbreLpsa();               
                }
                if($event->getNbreContracte()){
                    $mt['nbContracte'] = $mt['nbContracte'] + $event->getNbreContracte();               
                }
            }
            if($corporel && ($corporel->getTypeCorporel()->getId() === self::LTI) && (in_array($event->getCorporel()->getId(),$this->nbAvecArret))){
                if($event->getNbreLpsa()){
                    $nbLostTimeAccidentRepositories += $event->getNbreLpsa();               
                }
                if($event->getNbreContracte()){
                    $nbLostTimeAccidentRepositories += $event->getNbreContracte();               
                }
                if($event->getNbreTiers()){
                    $nbLostTimeAccidentRepositories += $event->getNbreTiers();               
                }
            }
            if($corporel && ($corporel->getTypeCorporel()->getId() === self::ACCIDENT_NON_STOP) && in_array($corporel->getId(),$this->nbAvecArret)){
                if($event->getNbreLpsa()){
                    $nbAccidentRepositories += $event->getNbreLpsa();               
                }
                if($event->getNbreContracte()){
                    $nbAccidentRepositories += $event->getNbreContracte();               
                }
                if($event->getNbreTiers()){
                    $nbAccidentRepositories += $event->getNbreTiers();               
                }
            }
            if($corporel && ($corporel->getId() === self::FA)){
                if($event->getNbreLpsa()){
                    $fa['nbLpsa'] = $fa['nbLpsa'] + $event->getNbreLpsa();               
                }
                if($event->getNbreContracte()){
                    $fa['nbContracte'] = $fa['nbContracte'] + $event->getNbreContracte();               
                }
            }
        }
        foreach($depotCategorieEvents as $event){
            $corporel = $event->getCorporel();
            //Nbre d'accidents "Siège" sans arrêt
            if($corporel && ($event->getDepot()->getDepotCategories()->getId() === self::DEPOT_SIEGE) && ($corporel->getTypeCorporel()->getId() === self::ACCIDENT_NON_STOP) && in_array($corporel->getId(),$this->nbAvecArret)){
                if($event->getNbreLpsa()){
                    $nbAccidentCenter += $event->getNbreLpsa();               
                }
                if($event->getNbreContracte()){
                    $nbAccidentCenter += $event->getNbreContracte();               
                }
                if($event->getNbreTiers()){
                    $nbAccidentCenter += $event->getNbreTiers();               
                }
            }
            //Nbre d'accidents "Siège" sans arrêt
            if(($event->getDepot()->getDepotCategories()->getId() === self::DEPOT_SIEGE) && ($event->getCorporel()->getTypeCorporel()->getId() === self::LTI) && (in_array($event->getId(),$this->nbAvecArret))){
                if($event->getNbreLpsa()){
                    $nbLostTimeAccidentCenter += $event->getNbreLpsa();               
                }
                if($event->getNbreContracte()){
                    $nbLostTimeAccidentCenter += $event->getNbreContracte();               
                }
                if($event->getNbreTiers()){
                    $nbLostTimeAccidentCenter += $event->getNbreTiers();               
                }
            }
        }
        $categoriesId = $this->container->getParameter('categories_id');
        $nbAgression = $nbVol = $nbIntrusion = 0;
        $presqueAccident = $situationDangereuse = 0;
        $incidentPotentiel = 0;
        $nbAnalyseParArbreCauseRealise = 0;
        foreach($categorieEvents as $event){
            $nbEvenementReporte++;
            $corporel = $event->getCorporel();
            $typeAccident = $event->getTypeAccident();
            //accident: transport maritime/terrestre
            if($event->getCategorie()->getId() === $categoriesId['accident'] && $corporel && $typeAccident){
                //avec arrêt
                if($corporel->getTypeCorporel()->getId() === self::LTI){
                    if($typeAccident->getId() === $this->typeAccident['maritime']){
                        $nbTransportMaritimeAvecArret++;
                    }
                    if($typeAccident->getId() === $this->typeAccident['terrestre']){
                        $nbTransportTerrestreAvecArret++;
                    }                                                     
                }
                //sans arrêt
                if($corporel->getTypeCorporel()->getId() === self::ACCIDENT_NON_STOP){
                    if($typeAccident->getId() === $this->typeAccident['maritime']){
                        $nbTransportMaritimeSansArret++;
                    }
                    if($typeAccident->getId() === $this->typeAccident['terrestre']){
                        $nbTransportTerrestreSansArret++;
                    }     
                }  
            }
            //Nombre de Presqu'Accidents (PA)
            if($event->getCategorie()->getId() === self::PRESQUE_ACCIDENT){
                $presqueAccident++;
            }  
            //Situation dangereuse
            if($event->getCategorie()->getId() === self::SITUATION_DANGEREUSE){
                $situationDangereuse++;
                $nbAnalyseParArbreCauseRealise++;
            }  
            //Incident potentiel
            if($event->getGravite() && (int)$event->getGravite()->getValeur() > self::INCIDENT_POTENTIEL){
                $incidentPotentiel++;
            }                 
            $typeSituationDangereuse = $event->getTypeSituationDangereuse();
            if($event->getCategorie()->getId() === $categoriesId['situation_dangereuse'] && $typeSituationDangereuse){
                if($typeSituationDangereuse->getId() === $this->typeSituationDangereuse['agression']){
                    $nbAgression++;
                }
                if($typeSituationDangereuse->getId() === $this->typeSituationDangereuse['vol']){
                    $nbVol++;
                }
                if($typeSituationDangereuse->getId() === $this->typeSituationDangereuse['intrusion']){
                    $nbIntrusion++;
                }    
            }
        }
        $exerciceUrgences = $this->em->getRepository('LpsaAppBundle:ExerciceUrgence')->findAllByYear($dateEnd->format('Y'));
        $nbPoi = $nbMiniPoi = $nbPum = $nbCombine = $nbCmc = 0;
        foreach($exerciceUrgences as $exerciceUrgence){
            $nbPoi += $exerciceUrgence->getNbrePoi();
            $nbMiniPoi += $exerciceUrgence->getNbreMiniPoi();
            $nbPum += $exerciceUrgence->getNbrePum();
            $nbCombine += $exerciceUrgence->getNbreCombine();
            $nbCmc += $exerciceUrgence->getNbreCmc();
        }
        $toolbox = $this->em->getRepository('LpsaAppBundle:Toolbox')->findAllByYear($dateEnd->format('Y'));
        $toolboxSiege = $toolboxDepots = $toolboxSct = 0;
        foreach($toolbox as $value){
            $toolboxSiege += $value->getSiege();
            $toolboxDepots += $value->getDepots();
            $toolboxSct += $value->getSct();
        }
        $visites = $this->em->getRepository('LpsaAppBundle:Visite')->findAllByYear($dateEnd->format('Y'));
        $visite = 0;
        foreach($visites as $value){
            $visite += $value->getNbreVisite();
        }
        $piezometres = $this->em->getRepository('LpsaAppBundle:Piezometre')->findAllByYear($dateEnd->format('Y'));
        $piezometreNbEchantillonPreleve = $piezometreNbEchantillonAnalyse = $piezometreNbAnomalieReleve = $piezometreTauxNonConformite = 0;
        foreach($piezometres as $value){
            $piezometreNbEchantillonPreleve += $value->getNbreEchantillonPreleve();
            $piezometreNbEchantillonAnalyse += $value->getNbreEchantillonAnalyse();
            $piezometreNbAnomalieReleve += $value->getNbreAnomalieReleve();
            $piezometreTauxNonConformite += (float) $value->getTauxNonConformite();
        }
        $decanteurs = $this->em->getRepository('LpsaAppBundle:Decanteur')->findAllByYear($dateEnd->format('Y'));
        $decanteurNbEchantillonPreleve = $decanteurNbEchantillonAnalyse = $decanteurNbAnomalieReleve = $decanteurTauxNonConformite = 0;
        foreach($decanteurs as $value){
            $decanteurNbEchantillonPreleve += $value->getNbreEchantillonPreleve();
            $decanteurNbEchantillonAnalyse += $value->getNbreEchantillonAnalyse();
            $decanteurNbAnomalieReleve += $value->getNbreAnomalieReleve();
            $decanteurTauxNonConformite += (float) $value->getTauxNonConformite();
        }
        $laboratoires = $this->em->getRepository('LpsaAppBundle:Laboratoire')->findAllByYear($dateEnd->format('Y'));
        $laboratoireResultatEssaiCirculaire = $laboratoireNbEchantillonPreleve = $laboratoireNbEchantillonAnalyse = $laboratoireNbAnomalieReleve = $laboratoireTauxNonConformite = 0;    
        foreach($laboratoires as $value){
            $laboratoireNbEchantillonPreleve += $value->getNbreEchantillonPreleve();
            $laboratoireNbEchantillonAnalyse += $value->getNbreEchantillonAnalyse();
            $laboratoireNbAnomalieReleve += $value->getNbreAnomalieReleve();
            $laboratoireResultatEssaiCirculaire += (float) $value->getResultatEssaiCirculaire();
        }  
        if($laboratoireNbEchantillonAnalyse > 0){
            $laboratoireTauxNonConformite = (float) ($laboratoireNbAnomalieReleve / $laboratoireNbEchantillonAnalyse) * 100;
        }  
        $environmentEvents = $this->eventManager->getRepository()->findWithEnvironmentByDate($dateStart,$dateEnd);
        $environmentLess1m3ZE = $environmentMore1m3ZE = $environmentLess1m3ZNE = $environmentMore1m3ZNE = 0;
        $nbFuiteflexible = 0; 
        foreach($environmentEvents as $event){
            $environment = $event->getEnvironnement();
            if($environment && ($environment->getTypeEnvironnement()->getId() === self::ZONE_ETANCHE) && ($environment->getId() === self::ENVIRONMENT_ZE_LESS_1_M3)){
                $environmentLess1m3ZE++;
            }
            if($environment && ($environment->getTypeEnvironnement()->getId() === self::ZONE_ETANCHE) && ($environment->getId() !== self::ENVIRONMENT_ZE_LESS_1_M3)){
                $environmentMore1m3ZE++;
            }
            if($environment && ($environment->getTypeEnvironnement()->getId() === self::ZONE_NON_ETANCHE) && ($environment->getId() === self::ENVIRONMENT_ZNE_LESS_1_M3)){
                $environmentLess1m3ZNE++;
            }
            if($environment && ($environment->getTypeEnvironnement()->getId() === self::ZONE_NON_ETANCHE) && ($environment->getId() !== self::ENVIRONMENT_ZNE_LESS_1_M3)){
                $environmentMore1m3ZNE++;
            }
            if($environment && in_array($environment->getId(),$this->fuiteflexibleIds)){
                $nbFuiteflexible++;
            }
        }
        $indicateurTransports = $this->em->getRepository('LpsaAppBundle:IndicateurTransport')->findAllByYear($dateEnd->format('Y'));
        $nbreJourAccidentCorporelTransportRoute = $kmAccidentCorporelTransportRoute = $nbreJourAccidentCorporelTransportRail = $kmAccidentCorporelTransportRail = 0;
        $nbreJourIncidentTransportMaritime = $kmIncidentTransportMaritime = $nbreJourFatalite = $tauxSinistraliteMatiereDangereuse = 0;
        $kmVehiculeLeger = $tauxSinistraliteVehiculeLeger = 0;
        foreach($indicateurTransports as $value){
            $nbreJourAccidentCorporelTransportRoute += (float) $value->getNbreJourAccidentCorporelTransportRoute();
            $kmAccidentCorporelTransportRoute += (float) $value->getKmAccidentCorporelTransportRoute();
            $nbreJourAccidentCorporelTransportRail += (float) $value->getNbreJourAccidentCorporelTransportRail();
            $kmAccidentCorporelTransportRail += (float) $value->getKmAccidentCorporelTransportRail();
            $nbreJourIncidentTransportMaritime += (float) $value->getNbreJourIncidentTransportMaritime();
            $kmIncidentTransportMaritime += (float) $value->getKmIncidentTransportMaritime();
            $nbreJourFatalite += (float) $value->getNbreJourFatalite();
            $tauxSinistraliteMatiereDangereuse += (float) $value->getTauxSinistraliteMatiereDangereuse();
            $kmVehiculeLeger += (float) $value->getKmVehiculeLeger();
            $tauxSinistraliteVehiculeLeger += (float) $value->getTauxSinistraliteVehiculeLeger();
        }

        $nbreNonConformiteCloture = $nbreNonConformiteNonEchue = $nbreOVERDUE = $nbPaqssse = 0;
        $PAQSSSEs = $this->eventManager->getRepository()->findAllPaqssse($dateStart,$dateEnd);
        foreach($PAQSSSEs as $value){
            $paq3se = $value->getPaq3se();
            if($paq3se && $paq3se->getDateFin()){
                $nbPaqssse++;
                $now = new \DateTime('now');
                $diff = $now->diff($paq3se->getDateFin());
                if($diff->days === 0 && ($value->getEvenementStatut() === self::STATUT_NON_CLOTURE)){
                    $nbreNonConformiteNonEchue++;
                }
                if($value->getEvenementStatut() === self::STATUT_NON_CLOTURE){
                    $nbreNonConformiteCloture++;
                } 
                if($diff->days > 0){
                    $nbreOVERDUE++;
                }
            }
        }
        //Fuite Fuite 
        $fuiteProduits = $this->em->getRepository('LpsaAppBundle:FuiteProduit')->findAllByYear($dateEnd->format('Y'));
        $fuiteNonMesurable = 0;
        foreach($fuiteProduits as $value){
            $fuiteNonMesurable += $value->getFuiteNonMesurable();
        }

        $ltirTrir = $this->getLastTrirLtir($dateStart,$dateEnd);
        $kpihse = new KPIHSE();
        $kpihse->setFat($fat)
               ->setTotalFat($fat['nbLpsa'] + $fat['nbContracte'] + $fat['nbTiers'])
               ->setLti($lti)
               ->setTotalLti($lti['nbLpsa'] + $lti['nbContracte'])
               ->setRwc($rwc)
               ->setTotalRwc($rwc['nbLpsa'] + $rwc['nbContracte'])
               ->setMt($mt)
               ->setTotalMt($mt['nbLpsa'] + $mt['nbContracte'])
               ->setFa($fa)
               ->setTotalFa($fa['nbLpsa'] + $fa['nbContracte'])
               ->setNbLostTimeAccidentRepositories($nbLostTimeAccidentRepositories)
               ->setNbAccidentRepositories($nbAccidentRepositories)
               ->setNbAccidentCenter($nbAccidentCenter)
               ->setNbLostTimeAccidentCenter($nbLostTimeAccidentCenter)
               ->setLtir($ltirTrir['ltir'])
               ->setTrir($ltirTrir['trir'])
               ->setLtir12($ltirTrir['ltir12'])
               ->setTrir12($ltirTrir['trir12'])
               ->setNbTransportTerrestreSansArret($nbTransportTerrestreSansArret)
               ->setNbTransportTerrestreAvecArret($nbTransportTerrestreAvecArret)
               ->setNbTransportMaritimeSansArret($nbTransportMaritimeSansArret)
               ->setNbTransportMaritimeAvecArret($nbTransportMaritimeAvecArret)
               ->setNbVol($nbVol)
               ->setNbAgression($nbAgression)
               ->setNbIntrusion($nbIntrusion)
               ->setNbPoi($nbPoi)
               ->setNbMiniPoi($nbMiniPoi)
               ->setNbCombine($nbCombine)
               ->setNbCmc($nbCmc)
               ->setNbPum($nbPum)
               ->setToolboxSiege($toolboxSiege)
               ->setToolboxDepots($toolboxDepots)
               ->setToolboxSct($toolboxSct)
               ->setVisite($visite)
               ->setDate($dateEnd)
               ->setPiezometreNbEchantillonPreleve($piezometreNbEchantillonPreleve)
               ->setPiezometreNbEchantillonAnalyse($piezometreNbEchantillonAnalyse)
               ->setPiezometreNbAnomalieReleve($piezometreNbAnomalieReleve)
               ->setPiezometreTauxNonConformite($piezometreTauxNonConformite)
               ->setDecanteurNbEchantillonPreleve($decanteurNbEchantillonPreleve)
               ->setDecanteurNbEchantillonAnalyse($decanteurNbEchantillonAnalyse)
               ->setDecanteurNbAnomalieReleve($decanteurNbAnomalieReleve)
               ->setDecanteurTauxNonConformite($decanteurTauxNonConformite)
               ->setLaboratoireNbEchantillonPreleve($laboratoireNbEchantillonPreleve)
               ->setLaboratoireNbEchantillonAnalyse($laboratoireNbEchantillonAnalyse)
               ->setLaboratoireNbAnomalieReleve($laboratoireNbAnomalieReleve)
               ->setLaboratoireResultatEssaiCirculaire($laboratoireResultatEssaiCirculaire)
               ->setEnvironmentLess1m3ZE($environmentLess1m3ZE)
               ->setEnvironmentMore1m3ZE($environmentMore1m3ZE)
               ->setEnvironmentLess1m3ZNE($environmentLess1m3ZNE)
               ->setEnvironmentMore1m3ZNE($environmentMore1m3ZNE)
               ->setNbreJourAccidentCorporelTransportRoute($nbreJourAccidentCorporelTransportRoute)
               ->setKmAccidentCorporelTransportRoute($kmAccidentCorporelTransportRoute)
               ->setNbreJourAccidentCorporelTransportRail($nbreJourAccidentCorporelTransportRail)
               ->setKmAccidentCorporelTransportRail($kmAccidentCorporelTransportRail)
               ->setNbreJourIncidentTransportMaritime($nbreJourIncidentTransportMaritime)
               ->setKmIncidentTransportMaritime($kmIncidentTransportMaritime)
               ->setNbreJourFatalite($nbreJourFatalite)
               ->setTauxSinistraliteMatiereDangereuse($tauxSinistraliteMatiereDangereuse)
               ->setKmVehiculeLeger($kmVehiculeLeger)
               ->setTauxSinistraliteVehiculeLeger($tauxSinistraliteVehiculeLeger)
               ->setNbreNonConformiteCloture($nbreNonConformiteCloture)
               ->setNbreNonConformiteNonEchue($nbreNonConformiteNonEchue)
               ->setNbreOVERDUE($nbreOVERDUE)
               ->setNbTotalPaqssse($nbPaqssse)
               ->setFar($ltirTrir['cumulFar'])
               ->setFar12($ltirTrir['cumulFar12'])
               ->setPresqueAccident($presqueAccident)
               ->setSituationDangereuse($situationDangereuse)
               ->setIncidentPotentiel($incidentPotentiel)
               ->setNbEvenementReporte($nbEvenementReporte)
               ->setNbLpsaRecap($this->nbUsers)
               ->setNbParArbreCauseRealise($nbAnalyseParArbreCauseRealise)
               ->setNbFuiteflexible($nbFuiteflexible)
               ->setFuiteNonMesurable($fuiteNonMesurable)
               ;
        return $kpihse;
    }

    private function getLastTrirLtir($dateStart,$dateEnd){
        $ltir_trir = $this->container->get('app.statistic.ltir_trir');   
        $ltir_trir->process($dateStart,$dateEnd);     
        $cumulTrir = 0;
        $cumulFar = 0;
        $cumulFar12 = 0;
        foreach($ltir_trir->getTRIR() as $trir){
            $cumulTrir += $trir->getTRIR();
            $cumulFar += $trir->getFar();
        }
        $cumulLtir = 0;
        foreach($ltir_trir->getLTIR() as $ltir){
            $cumulLtir += $ltir->getLTIR();
        }
        $cumulLtir12 = 0;
        foreach($ltir_trir->getLTIR12Months() as $ltir){
            $cumulLtir12 += $ltir->getLTIR();
            $cumulFar12 += $ltir->getFar();
        }
        $cumulTrir12 = 0;
        foreach($ltir_trir->getTRIR12Months() as $trir){
            $cumulTrir12 += $trir->getTRIR();
        }
        return [
            'trir' => $cumulTrir,
            'ltir' => $cumulLtir,
            'trir12' => $cumulTrir12,
            'ltir12' => $cumulLtir12,
            'cumulFar' => $cumulFar,
            'cumulFar12' => $cumulFar12
        ];
    }

    public function getDateStart(){
        return $this->dateStart;
    }

    public function getDateEnd(){
        return $this->dateEnd;
    }

    public function getObjectifKpihse(){
        $entity = $this->em->getRepository('LpsaAppBundle:ObjectifKpihse')->findByYear($this->getDateEnd()->format('Y'));
        $objectifKpihse = new ObjectifKpihse();
        $objectifKpihse->setDateEnd($this->getDateEnd());
        if($entity){
            $objectifKpihse
                ->setNbreFatLpsa($entity->getNbreFatLpsa())
                ->setNbreFatContracte($entity->getNbreFatContracte())
                ->setNbreFatTiers($entity->getNbreFatTiers())
                ->setNbreLtiLpsa($entity->getNbreLtiLpsa())
                ->setNbreLtiContracte($entity->getNbreLtiContracte())
                ->setRwc($entity->getRwc())
                ->setNbreMtLpsa($entity->getNbreMtLpsa())
                ->setNbreMtContracte($entity->getNbreMtContracte())
                ->setNbreFaLpsa($entity->getNbreFaLpsa())
                ->setNbreFaContracte($entity->getNbreFaContracte())
                ->setTri($entity->getTri())
                ->setTrir12Mois($entity->getTrir12Mois())
                ->setLtir12Mois($entity->getLtir12Mois())
                ->setTrir($entity->getTrir())
                ->setLtir($entity->getLtir())
                ->setFar($entity->getFar())
                ->setFar12Mois($entity->getFar12Mois())
                ->setNbreAccidentDepotAvecArret($entity->getNbreAccidentDepotAvecArret())
                ->setNbreAccidentTransportTerrestreAvecArret($entity->getNbreAccidentTransportTerrestreAvecArret())
                ->setNbreLtiTransportTerrestreAvecArret($entity->getNbreLtiTransportTerrestreAvecArret())
                ->setNbreAccidentTransportMaritimeAvecArret($entity->getNbreAccidentTransportMaritimeAvecArret())
                ->setNbreAccidentSiegeAvecArret($entity->getNbreAccidentSiegeAvecArret())
                ->setNbreAccidentDepotSansArret($entity->getNbreAccidentDepotSansArret())
                ->setNbreAccidentTransportTerrestreSansArret($entity->getNbreAccidentTransportTerrestreSansArret())
                ->setNbreLtiTransportTerrestreSansArret($entity->getNbreLtiTransportTerrestreSansArret())
                ->setNbreAccidentTransportMaritimeSansArret($entity->getNbreAccidentTransportMaritimeSansArret())
                ->setNbreAccidentSiegeSansArret($entity->getNbreAccidentSiegeSansArret())
                ->setNbreAgression($entity->getNbreAgression())
                ->setNbreVol($entity->getNbreVol())
                ->setNbreIntrusion($entity->getNbreIntrusion())
                ->setNbreJourDernierAccidentCorporelRoute($entity->getNbreJourDernierAccidentCorporelRoute())
                ->setKmDernierAccidentCorporelRoute($entity->getKmDernierAccidentCorporelRoute())
                ->setNbreJourDernierAccidentCorporelRail($entity->getNbreJourDernierAccidentCorporelRail())
                ->setKmDernierAccidentCorporelRail($entity->getKmDernierAccidentCorporelRail())
                ->setNbreJourDernierIncidentMaritime($entity->getNbreJourDernierIncidentMaritime())
                ->setMilesDernierIncidentMaritime($entity->getMilesDernierIncidentMaritime())
                ->setNbreJourDernierFatalite($entity->getNbreJourDernierFatalite())
                ->setTauxSinistralite($entity->getTauxSinistralite())
                ->setKmVehiculeLeger($entity->getKmVehiculeLeger())
                ->setTauxSinistraliteVehiculeLeger($entity->getTauxSinistraliteVehiculeLeger())
                ->setNbreExercicePoi($entity->getNbreExercicePoi())
                ->setNbreExerciceMiniPoi($entity->getNbreExerciceMiniPoi())
                ->setNbreExercicePum($entity->getNbreExercicePum())
                ->setNbreExerciceCombine($entity->getNbreExerciceCombine())
                ->setNbreExerciceCmc($entity->getNbreExerciceCmc())
                ->setNbreVisiteCodir($entity->getNbreVisiteCodir())
                ->setNbreEvenementReporte($entity->getNbreEvenementReporte())
                ->setIndiceReporting($entity->getIndiceReporting())
                ->setNbrePresqueAccident($entity->getNbrePresqueAccident())
                ->setNbreActeSituationDangereuse($entity->getNbreActeSituationDangereuse())
                ->setNbreIncidentPotentiel($entity->getNbreIncidentPotentiel())
                ->setNbreAnalyseArbreCauseRealise($entity->getNbreAnalyseArbreCauseRealise())
                ->setZoneEtancheSup159($entity->getZoneEtancheSup159())
                ->setZoneEtancheInf159($entity->getZoneEtancheInf159())
                ->setZoneNonEtancheSup159($entity->getZoneNonEtancheSup159())
                ->setZoneNonEtancheInf159($entity->getZoneNonEtancheInf159())
                ->setFuiteProduitNonMesurable($entity->getFuiteProduitNonMesurable())
                ->setPollutionMarine($entity->getPollutionMarine())
                ->setPiezometreNbEchantillonPreleve($entity->getPiezometreNbEchantillonPreleve())
                ->setPiezometreNbEchantillonAnalyse($entity->getPiezometreNbEchantillonAnalyse())
                ->setPiezometreNbAnomalieReleve($entity->getPiezometreNbAnomalieReleve())
                ->setPiezometreTauxNonConformite($entity->getPiezometreTauxNonConformite())
                ->setDecanteurNbEchantillonPreleve($entity->getDecanteurNbEchantillonPreleve())
                ->setDecanteurNbEchantillonAnalyse($entity->getDecanteurNbEchantillonAnalyse())
                ->setDecanteurNbAnomalieReleve($entity->getDecanteurNbAnomalieReleve())
                ->setDecanteurTauxNonConformite($entity->getDecanteurTauxNonConformite())
                ->setLaboratoireNbEchantillonPreleve($entity->getLaboratoireNbEchantillonPreleve())
                ->setLaboratoireNbEchantillonAnalyse($entity->getLaboratoireNbEchantillonAnalyse())
                ->setLaboratoireNbAnomalieReleve($entity->getLaboratoireNbAnomalieReleve())
                ->setLaboratoireTauxNonConformite($entity->getLaboratoireTauxNonConformite())
                ->setLaboratoireResultatEssaiCirculaire($entity->getLaboratoireResultatEssaiCirculaire())
                ->setNbreNonConformiteCloture($entity->getNbreNonConformiteCloture())
                ->setNbreNonConformiteNonEchue($entity->getNbreNonConformiteNonEchue())
                ->setNbreOVERDUE($entity->getNbreOVERDUE())
                ->setPourcentageOVERDUE($entity->getPourcentageOVERDUE())
                ->setToolboxSiege($entity->getToolboxSiege())
                ->setToolboxDepot($entity->getToolboxDepot())
                ->setToolboxSct($entity->getToolboxSct())
                ;
        }
        return $objectifKpihse;
    }
}