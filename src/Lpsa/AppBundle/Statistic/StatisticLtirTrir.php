<?php

namespace Lpsa\AppBundle\Statistic;

use Lpsa\AppBundle\Entity\Manager\Interfaces\EvenementManagerInterface;
use Lpsa\AppBundle\Entity\Manager\Interfaces\HeureTravailManagerInterface;
use Lpsa\AppBundle\Entity\Manager\Interfaces\ObjectifLtirTrirManagerInterface;
use Lpsa\AppBundle\Statistic\Model\TRIR;
use Lpsa\AppBundle\Statistic\Model\LTIR;

class StatisticLtirTrir extends StatisticDataBinding{

    /**
     * @var EvenementManagerInterface
     */
    protected $eventManager;

    /**
     * @var HeureTravailManagerInterface
     */
    protected $hourManager;
    /**
     *
     * @var type ObjectifLtirTrirManagerInterface
     */
    protected $objectifLtirTrirManager;
    
    private $aTRIR = array();

    private $aLTIR = array();

    private $corporelEvents;

    private $monthHeaders = array();

    private $hours = array();

    private $hoursLastYear = array();
    
    private $objectifLtirTrir = array();
    
    private $objectifLtirTrirLastYear = array();

    private $dateEnd = null;

    private $dateStart = null;

    private $dateStart12Month = null;

    private $dateEnd12Month = null;

    private $aTRIR12Months = array();

    private $aLTIR12Months = array();

    private $matrixTrir = array();

    private $matrixLtir = array();

    private $allHours = array();

    private $allTrir = array();

    private $allLtir = array();

    /* construct.
     *
     * @param EvenementManagerInterface $eventManager
     * @param HeureTravailManagerInterface $hourManager
     */
    public function __construct(EvenementManagerInterface $eventManager,HeureTravailManagerInterface $hourManager,ObjectifLtirTrirManagerInterface $objectifLtirTrirManager)
    {
        $this->eventManager = $eventManager;    
        $this->hourManager = $hourManager;
        $this->objectifLtirTrirManager = $objectifLtirTrirManager;
    }

    //initialisation des données
    public function process($dateStart = null,$dateEnd = null){
        if($dateStart === null){
            $dateStart = $this->initDefaultDateStart();
        }
        if($dateEnd === null){
            $dateEnd = $this->initDefaultDateEnd();            
        }
        $this->dateEnd = $dateEnd;
        $this->dateStart = $dateStart;
        $this->fetchCorporelEvents($dateStart,$dateEnd)
             ->fetchHoursForYears()
             ->fetchObjectifLtirTrir($dateEnd)
             ->prepareData()
             ;
    }

    public function getMonthHeaders12Months(){
        return $this->monthHeaders12Months;
    }

    public function getTRIR12Months(){
        return $this->aTRIR12Months;
    }

    public function getLTIR12Months(){
        return $this->aLTIR12Months;
    }

    public function getMonthHeaders(){
        return $this->monthHeaders;
    }

    public function getTRIR(){
        return $this->aTRIR;
    }

    public function getLTIR(){
        return $this->aLTIR;
    }

    public function getDateStart(){
        return $this->dateStart;
    }

    public function getDateEnd(){
        return $this->dateEnd;
    }
    public function getObjectifLtirTrir(){
        return $this->objectifLtirTrir;
    }

    //construction de la matrice de données, indispensable pour les calculs par rapport aux dates glissants
    private function setMatrixValue(){
        foreach($this->aTRIR as $month => $trir){
            $trir->setMatrix($this->allTrir);
            $this->aLTIR[$month]->setMatrix($this->allLtir);
        }
        foreach($this->aTRIR12Months as $month => $trir){
            $trir->setMatrix($this->allTrir);
            $this->aLTIR12Months[$month]->setMatrix($this->allLtir);
        }
    }

    //construction de la date de départ pour la requête
    private function initDefaultDateStart(){
        $now = new \DateTime('now');
        if($this->dateStart === null){
            $lastYear = $now->modify('-1 year');
            $this->dateStart = new \DateTime($lastYear->format('Y') . '-12-' . self::MONTH_DAY_START);
        }
        return $this->dateStart;
    }

    //construction de la date fin pour la requête
    private function initDefaultDateEnd(){
        $now = new \DateTime('now');
        if($this->dateEnd === null){
            $this->dateEnd = new \DateTime($now->format('Y') . '-12-' . self::MONTH_DAY_END);
        }
        return $this->dateEnd;
    }

    //construction d'une matrice M(i,j) avec i l'annee et j les heures par mois 
    private function  fetchHoursForYears(){
        $year = intval($this->dateStart->format('Y'));
        $entities = $this->hourManager->getRepository()->findAllByYear($year);
        $aHours = $this->pushHoursToArray($year,$entities);
        $year = intval($this->dateEnd->format('Y'));
        $entities = $this->hourManager->getRepository()->findAllByYear($year);
        $aHours = $this->pushHoursToArray($year,$entities,$aHours);
        //obtention date 12 mois glissants
        $dates = $this->getLatestDate($this->dateStart,$this->dateEnd);
        $dateStart = $dates['dateStart'];
        $dateEnd = $dates['dateEnd'];
        $year = intval($dateStart->format('Y'));
        $entities = $this->hourManager->getRepository()->findAllByYear($year);
        $aHours = $this->pushHoursToArray($year,$entities,$aHours);
        $year = intval($dateEnd->format('Y'));
        $entities = $this->hourManager->getRepository()->findAllByYear($year);
        $aHours = $this->pushHoursToArray($year,$entities,$aHours);
        //obtention 24 mois glissants
        $dates = $this->getLatestDate($dateStart,$dateEnd,1);
        $dateStart = $dates['dateStart'];
        $dateEnd = $dates['dateEnd'];
        $year = intval($dateStart->format('Y'));
        $entities = $this->hourManager->getRepository()->findAllByYear($year);
        $aHours = $this->pushHoursToArray($year,$entities,$aHours);
        $year = intval($dateEnd->format('Y'));
        $entities = $this->hourManager->getRepository()->findAllByYear($year);
        $aHours = $this->pushHoursToArray($year,$entities,$aHours);
        $this->allHours = $aHours;
        return $this;
    }

    //obtention des dates antérieurs par rapport aux dates spécifiées par la recherche
    private function getLatestDate($dateStart,$dateEnd,$sub = 0){
        $currentYear = intval($dateStart->format('Y'));
        $year = intval($dateStart->format('Y'));
        $isEqualYear = false;
        if($currentYear === intval($dateEnd->format('Y'))){
            $currentYear--;
            $year--;
            $isEqualYear = true;
        }
        /*if($sub > 0){
            $currentYear -= $sub;
        }*/
        $month = intval($dateStart->format('m'));
        $day = intval($dateStart->format('d'));        
        $currentMonth = $month;
        if($day < self::MONTH_DAY_END){
            $currentMonth--;
        }
        if($currentMonth < 1){
            $currentMonth = 12;
        }
        $latestMonth = $month;
        if($month === 12){
            $latestMonth = 11;
        }
        $yearly = $year;
        if($currentMonth === 12){
            $latestMonth = 11;
        }
        for($i = 0;$i < 11; $i++){
            $latestMonth--;
            if($latestMonth < 1){
                $latestMonth = 12;
                $yearly--;
            }
        }
        $newDateStart = new \DateTime($yearly . '-' . $latestMonth . '-' . self::MONTH_DAY_START);
        $newDateEnd = new \DateTime($currentYear . '-' . $currentMonth . '-' . self::MONTH_DAY_END);
        return array(
            'dateStart' => $newDateStart,
            'dateEnd'   => $newDateEnd,
            'isEqualYear' => $isEqualYear
        );
    }

    //Corporel events
    private function fetchCorporelEvents($dateStart,$dateEnd){
        $this->corporelEvents = $this->eventManager->getRepository()->findWithCorporelByDate($dateStart,$dateEnd);
        return $this;
    }
    
    private function fetchObjectifLtirTrir($dateEnd){
        $objectifLtirTrirs = $this->objectifLtirTrirManager->getRepository()->findByAnnee($dateEnd->format('Y'));
        $lastYear = intval($this->dateEnd->format('Y')) - 1;
        $objectifLtirsTrirLastYear = $this->objectifLtirTrirManager->getRepository()->findByAnnee($lastYear);
        if(!empty($objectifLtirTrirs)){
            reset($objectifLtirTrirs);
        }
        if(!empty($objectifLtirsTrirLastYear)){
            reset($objectifLtirsTrirLastYear);
        }
        foreach($objectifLtirTrirs as $key => $objectifLtirTrir){
            $this->objectifLtirTrir[$objectifLtirTrir->getMois()] = $this->getObjectifValue($objectifLtirTrir);
        }
        ksort($this->objectifLtirTrir);
        foreach($objectifLtirsTrirLastYear as $key => $objectifLtirTrirLastYear){
            $this->objectifLtirTrirLastYear[$objectifLtirTrirLastYear->getMois()] = $this->getObjectifValue($objectifLtirTrirLastYear);
        }
        ksort($this->objectifLtirTrirLastYear);
        reset($this->objectifLtirTrirLastYear);
      return $this;  
    }
    
    private function getHourValues($hours){
        $values = array();
        foreach($hours as $hour){
            if($hour->getHeureTravailCategorie()->getId() === self::HOUR_CATEGORY_LPSA){
                $values['lpsa'] = $hour->getHeure();
            }
            if($hour->getHeureTravailCategorie()->getId() === self::HOUR_CATEGORY_CONTRACTANT){
                $values['contractant'] = $hour->getHeure();
            }
        }
        if(!array_key_exists('lpsa',$values)){
            $values['lpsa'] = 0;
        }
        if(!array_key_exists('contractant',$values)){
            $values['contractant'] = 0;
        }
        return $values;
    }
    
    private function getObjectifValue($objectif){
        $values = array();
        $values['objectifLtir'] = $objectif->getLtir();
        $values['objectifTrir'] = $objectif->getTrir();
        return $values;
    }
    
    private function getParameterLimits($dateStart,$dateEnd){
        $limit = intval($dateEnd->format('m'));
        $start = intval($dateStart->format('m'));
        $year = intval($dateEnd->format('Y'));
        if($start > 11){
            $start = 1;
        }
        return [
            'limit' => $limit,
            'start' => $start,
            'year'  => $year
        ];
    }   

    private function prepare12Months(){
        //obtention date 12 mois glissants
        $dates = $this->getLatestDate($this->dateStart,$this->dateEnd);
        $dateStart = $dates['dateStart'];
        $dateEnd = $dates['dateEnd'];
        
        $this->dateStart12Month = $dateStart;
        $this->dateEnd12Month = $dateEnd;
        $corporelEvents = $this->eventManager->getRepository()->findWithCorporelByDate($dateStart,$dateEnd);
        $orderedEvents = array();
        foreach($corporelEvents as $event){
            $date = $event->getDateEmission();
            $day = intval($date->format('d'));
            $month = intval($date->format('m'));
            if($day > self::MONTH_DAY_END){
                $month++;//increment month
            } 
            $orderedEvents[$month][] = $event;
        }
        ksort($orderedEvents);
        $parameters = $this->getParameterLimits($dateStart,$dateEnd);
        $this->aTRIR12Months = $this->aLTIR12Months = $this->monthHeaders12Months = array();
        $month = $parameters['start'];
        
        //init kpihse for 1 year
        if($dates['isEqualYear']){
            $year = intval($this->dateStart->format('Y')) - 1;
        } else {
            $year = intval($dateStart->format('Y'));
        }
        if(intval($this->dateStart->format('m')) === 12){
            $year = intval($this->dateStart->format('Y'));
        }
        for($i = 1;$i <= 12; $i++){
            $this->aTRIR12Months[$month] = new TRIR();
            $this->aTRIR12Months[$month]->setDate(new \DateTime($year . "-$month-" . self::MONTH_DAY_START));
            $this->aLTIR12Months[$month] = new LTIR();
            $this->aLTIR12Months[$month]->setDate(new \DateTime($year . "-$month-" . self::MONTH_DAY_START));
            $this->monthHeaders12Months[$month] = new \DateTime($year . "-$month-" . self::MONTH_DAY_START);
            $month++;
            if($month > 12){
                $month = 1;
                $year++;
            }
        }
        foreach($this->aTRIR12Months as $month => $trir){
            $fat = array('nbLpsa' => 0,'nbContracte' => 0,'nbTiers' => 0);
            $pdc = array('nbLpsa' => 0,'nbContracte' => 0,'nbTiers' => 0);
            $lti = array('nbLpsa' => 0,'nbContracte' => 0);
            $rwc = array('nbLpsa' => 0,'nbContracte' => 0);
            $mt = array('nbLpsa' => 0,'nbContracte' => 0);
            $fa = array('nbLpsa' => 0,'nbContracte' => 0);
            $hours = array('contractant' => 0,'lpsa' => 0);
            $objectif = array('objectifLtir' => 0.00,'objectifTrir' => 0.00);
            if(array_key_exists($month,$orderedEvents)){
                $events = $orderedEvents[$month];
                foreach($events as $event){
                    $corporel = $event->getCorporel();
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
                    if($corporel && ($corporel->getTypeCorporel()->getId() === self::PDC)){
                        if($event->getNbreLpsa()){
                            $pdc['nbLpsa'] = $pdc['nbLpsa'] + $event->getNbreLpsa();               
                        }
                        if($event->getNbreContracte()){
                            $pdc['nbContracte'] = $pdc['nbContracte'] + $event->getNbreContracte();               
                        }
                        if($event->getNbreTiers()){
                            $pdc['nbTiers'] = $pdc['nbTiers'] + $event->getNbreTiers();               
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
            $dateTrir = $trir->getDate();
            $yearTrir = intval($dateTrir->format('Y'));
            if(array_key_exists($yearTrir,$this->allHours) && array_key_exists($month,$this->allHours[$yearTrir])){
                $hours = $this->allHours[$yearTrir][$month];
            } 
            if(array_key_exists($month,$this->objectifLtirTrirLastYear)){
                $objectif = $this->objectifLtirTrirLastYear[$month];
            }
            $trir->setFat($fat['nbLpsa'] + $fat['nbContracte'] + $fat['nbTiers'])
                 ->setPdc($pdc['nbLpsa'] + $pdc['nbContracte'] + $pdc['nbTiers'])
                 ->setLti($lti['nbLpsa'] + $lti['nbContracte'])
                 ->setRwc($rwc['nbLpsa'] + $rwc['nbContracte'])
                 ->setMt($mt['nbLpsa'] + $mt['nbContracte'])
                 ->setFa($fa['nbLpsa'] + $fa['nbContracte'])
                 ->setHeureLpsa($hours['lpsa'])
                 ->setHeureContractant($hours['contractant'])
                 ->setObjectifTrir($objectif['objectifTrir'])
                 ->setFar($this->calculFar($trir->getFa(), $trir->getHeureLpsa(), $trir->getHeureContractant()))
                 ->setTri($this->calculTri($trir->getFat(), $trir->getPdc(), $trir->getLti(), $trir->getMt(), $trir->getRwc()))
                 
               ;
            $this->aLTIR12Months[$month]->setFat($fat['nbLpsa'] + $fat['nbContracte'] + $fat['nbTiers'])
                 ->setPdc($pdc['nbLpsa'] + $pdc['nbContracte'] + $pdc['nbTiers'])
                 ->setLti($lti['nbLpsa'] + $lti['nbContracte'])
                 ->setRwc($rwc['nbLpsa'] + $rwc['nbContracte'])
                 ->setMt($mt['nbLpsa'] + $mt['nbContracte'])
                 ->setFa($fa['nbLpsa'] + $fa['nbContracte'])
                 ->setHeureLpsa($hours['lpsa'])
                 ->setHeureContractant($hours['contractant'])
                 ->setObjectifLtir($objectif['objectifLtir'])
                 ->setFar($this->calculFar($this->aLTIR12Months[$month]->getFa(), $this->aLTIR12Months[$month]->getHeureLpsa(), $this->aLTIR12Months[$month]->getHeureContractant()))
                 ->setTri($this->calculTri($this->aLTIR12Months[$month]->getFat(), $this->aLTIR12Months[$month]->getPdc(), $this->aLTIR12Months[$month]->getLti(), $this->aLTIR12Months[$month]->getMt(), $this->aLTIR12Months[$month]->getRwc()))
               ;
            $this->allTrir[$yearTrir][$month] = $trir;
            $this->allLtir[$yearTrir][$month] = $this->aLTIR12Months[$month];
        }
        
        foreach($this->aTRIR as $month => $trir){
            $trir->setLatest12Months($this->aTRIR12Months);
            $this->aLTIR[$month]->setLatest12Months($this->aLTIR12Months);
        }
    }

    private function pushHoursToArray($year,$entities,$arrays = array()){
        $hoursLastYear = array();
        if(!empty($entities)){
            reset($entities);
            $last = current($entities);
        }
        $tmp = array();
        foreach($entities as $key => $hour){
            if($last->getMois() !== $hour->getMois()){
                $hoursLastYear[$year][$last->getMois()] = $this->getHourValues($tmp);
                $tmp = array();
            }
            $tmp[] = $hour;
            if(($key === count($entities) - 1)){
                $hoursLastYear[$year][$hour->getMois()] = $this->getHourValues($tmp);
            }
            $last = $hour;
        }
        if(!empty($arrays)){
            $tmp = array();
            foreach($arrays as $key=>$val){
               $tmp[$key] = $val; 
            }
            foreach($hoursLastYear as $key=>$val){
               $tmp[$key] = $val; 
            }
            return $tmp;
        }
        return $hoursLastYear;
    }

    private function prepare24Months(){
        //obtention 24 mois glissants
        $dates = $this->getLatestDate($this->dateStart12Month,$this->dateEnd12Month,1);
        $dateStart = $dates['dateStart'];
        $dateEnd = $dates['dateEnd'];  
        $corporelEvents = $this->eventManager->getRepository()->findWithCorporelByDate($dateStart,$dateEnd);
        $orderedEvents = array();
        foreach($corporelEvents as $event){
            $date = $event->getDateEmission();
            $day = intval($date->format('d'));
            $month = intval($date->format('m'));
            if($day > self::MONTH_DAY_END){
                $month++;//increment month
            } 
            $orderedEvents[$month][] = $event;
        }
        ksort($orderedEvents);
        $parameters = $this->getParameterLimits($dateStart,$dateEnd);
        $year = $parameters['year'] - 1;
        $month = $parameters['start'];
        $aTRIR12Months = $aLTIR12Months = $monthHeaders12Months = array();
        
        //init kpihse for 1 year
        $year = intval($dateEnd->format('Y'));
        for($i = 1;$i <= 12; $i++){
            if(intval($dateStart->format('Y')) === $year && intval($dateStart->format('m')) === $month){
                break;
            }
            $aTRIR12Months[$month] = new TRIR();
            $aTRIR12Months[$month]->setDate(new \DateTime($year . "-$month-" . self::MONTH_DAY_START));
            $aLTIR12Months[$month] = new LTIR();
            $aLTIR12Months[$month]->setDate(new \DateTime($year . "-$month-" . self::MONTH_DAY_START));
            $monthHeaders12Months[$month] = new \DateTime($year . "-$month-" . self::MONTH_DAY_START);
            $month++;
            if($month > 12){
                $month = 1;
                $year = intval($dateStart->format('Y'));
            }
        } 
        foreach($aTRIR12Months as $month => $trir){
            $fat = array('nbLpsa' => 0,'nbContracte' => 0,'nbTiers' => 0);
            $pdc = array('nbLpsa' => 0,'nbContracte' => 0,'nbTiers' => 0);
            $lti = array('nbLpsa' => 0,'nbContracte' => 0);
            $rwc = array('nbLpsa' => 0,'nbContracte' => 0);
            $mt = array('nbLpsa' => 0,'nbContracte' => 0);
            $fa = array('nbLpsa' => 0,'nbContracte' => 0);
            $hours = array('contractant' => 0,'lpsa' => 0);
            $objectif = array('objectifLtir' => 0.00,'objectifTrir' => 0.00);
            if(array_key_exists($month,$orderedEvents)){
                $events = $orderedEvents[$month];
                foreach($events as $event){
                    $corporel = $event->getCorporel();
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
                    if($corporel && ($corporel->getTypeCorporel()->getId() === self::PDC)){
                        if($event->getNbreLpsa()){
                            $pdc['nbLpsa'] = $pdc['nbLpsa'] + $event->getNbreLpsa();               
                        }
                        if($event->getNbreContracte()){
                            $pdc['nbContracte'] = $pdc['nbContracte'] + $event->getNbreContracte();               
                        }
                        if($event->getNbreTiers()){
                            $pdc['nbTiers'] = $pdc['nbTiers'] + $event->getNbreTiers();               
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
            $dateTrir = $trir->getDate();
            $yearTrir = intval($dateTrir->format('Y'));
            if(array_key_exists($yearTrir,$this->allHours) && array_key_exists($month,$this->allHours[$yearTrir])){
                $hours = $this->allHours[$yearTrir][$month];
            }
            if(array_key_exists($month,$this->objectifLtirTrirLastYear)){
                $objectif = $this->objectifLtirTrirLastYear[$month];
            }       
            $trir->setFat($fat['nbLpsa'] + $fat['nbContracte'] + $fat['nbTiers'])
                 ->setPdc($pdc['nbLpsa'] + $pdc['nbContracte'] + $pdc['nbTiers'])
                 ->setLti($lti['nbLpsa'] + $lti['nbContracte'])
                 ->setRwc($rwc['nbLpsa'] + $rwc['nbContracte'])
                 ->setMt($mt['nbLpsa'] + $mt['nbContracte'])
                 ->setFa($fa['nbLpsa'] + $fa['nbContracte'])
                 ->setHeureLpsa($hours['lpsa'])
                 ->setHeureContractant($hours['contractant'])
                 ->setObjectifTrir($objectif['objectifTrir'])
                 ->setFar($this->calculFar($trir->getFa(), $trir->getHeureLpsa(), $trir->getHeureContractant()))
                 ->setTri($this->calculTri($trir->getFat(), $trir->getPdc(), $trir->getLti(), $trir->getMt(), $trir->getRwc()))
               ;
            $aLTIR12Months[$month]->setFat($fat['nbLpsa'] + $fat['nbContracte'] + $fat['nbTiers'])
                 ->setPdc($pdc['nbLpsa'] + $pdc['nbContracte'] + $pdc['nbTiers'])
                 ->setLti($lti['nbLpsa'] + $lti['nbContracte'])
                 ->setRwc($rwc['nbLpsa'] + $rwc['nbContracte'])
                 ->setMt($mt['nbLpsa'] + $mt['nbContracte'])
                 ->setFa($fa['nbLpsa'] + $fa['nbContracte'])
                 ->setHeureLpsa($hours['lpsa'])
                 ->setHeureContractant($hours['contractant'])
                 ->setObjectifLtir($objectif['objectifLtir'])
                 ->setFar($this->calculFar($aLTIR12Months[$month]->getFa(), $aLTIR12Months[$month]->getHeureLpsa(), $aLTIR12Months[$month]->getHeureContractant()))
                 ->setTri($this->calculTri($aLTIR12Months[$month]->getFat(), $aLTIR12Months[$month]->getPdc(), $aLTIR12Months[$month]->getLti(), $aLTIR12Months[$month]->getMt(), $aLTIR12Months[$month]->getRwc()))
               ;
            $this->allTrir[$yearTrir][$month] = $trir;
            $this->allLtir[$yearTrir][$month] = $aLTIR12Months[$month];
        }
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
        foreach($this->aTRIR as $month => $trir){
            $fat = array('nbLpsa' => 0,'nbContracte' => 0,'nbTiers' => 0);
            $pdc = array('nbLpsa' => 0,'nbContracte' => 0,'nbTiers' => 0);
            $lti = array('nbLpsa' => 0,'nbContracte' => 0);
            $rwc = array('nbLpsa' => 0,'nbContracte' => 0);
            $mt = array('nbLpsa' => 0,'nbContracte' => 0);
            $fa = array('nbLpsa' => 0,'nbContracte' => 0);
            $hours = array('contractant' => 0,'lpsa' => 0);
            $objectif = array('objectifLtir' => 0.00,'objectifTrir' => 0.00);
            if(array_key_exists($month,$orderedEvents)){
                $events = $orderedEvents[$month];
                foreach($events as $event){
                    $corporel = $event->getCorporel();
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
                    if($corporel && ($corporel->getTypeCorporel()->getId() === self::PDC)){
                        if($event->getNbreLpsa()){
                            $pdc['nbLpsa'] = $pdc['nbLpsa'] + $event->getNbreLpsa();               
                        }
                        if($event->getNbreContracte()){
                            $pdc['nbContracte'] = $pdc['nbContracte'] + $event->getNbreContracte();               
                        }
                        if($event->getNbreTiers()){
                            $pdc['nbTiers'] = $pdc['nbTiers'] + $event->getNbreTiers();               
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
            $dateTrir = $trir->getDate();
            $yearTrir = intval($dateTrir->format('Y'));
            if(array_key_exists($yearTrir,$this->allHours) && array_key_exists($month,$this->allHours[$yearTrir])){
                $hours = $this->allHours[$yearTrir][$month];
            }
            if(array_key_exists($month,$this->objectifLtirTrir)){
                $objectif = $this->objectifLtirTrir[$month];
            }
            $trir->setFat($fat['nbLpsa'] + $fat['nbContracte'] + $fat['nbTiers'])
                 ->setPdc($pdc['nbLpsa'] + $pdc['nbContracte'] + $pdc['nbTiers'])
                 ->setLti($lti['nbLpsa'] + $lti['nbContracte'])
                 ->setRwc($rwc['nbLpsa'] + $rwc['nbContracte'])
                 ->setMt($mt['nbLpsa'] + $mt['nbContracte'])
                 ->setFa($fa['nbLpsa'] + $fa['nbContracte'])
                 ->setHeureLpsa($hours['lpsa'])
                 ->setHeureContractant($hours['contractant'])
                 ->setObjectifTrir($objectif['objectifTrir'])
                 ->setFar($this->calculFar($trir->getFa(), $trir->getHeureLpsa(), $trir->getHeureContractant()))
                 ->setTri($this->calculTri($trir->getFat(), $trir->getPdc(), $trir->getLti(), $trir->getMt(), $trir->getRwc()))
               ;  
            $this->aLTIR[$month]->setFat($fat['nbLpsa'] + $fat['nbContracte'] + $fat['nbTiers'])
                 ->setPdc($pdc['nbLpsa'] + $pdc['nbContracte'] + $pdc['nbTiers'])
                 ->setLti($lti['nbLpsa'] + $lti['nbContracte'])
                 ->setRwc($rwc['nbLpsa'] + $rwc['nbContracte'])
                 ->setMt($mt['nbLpsa'] + $mt['nbContracte'])
                 ->setFa($fa['nbLpsa'] + $fa['nbContracte'])
                 ->setHeureLpsa($hours['lpsa'])
                 ->setHeureContractant($hours['contractant'])
                 ->setObjectifLtir($objectif['objectifLtir'])
                 ->setFar($this->calculFar($this->aLTIR[$month]->getFa(), $this->aLTIR[$month]->getHeureLpsa(), $this->aLTIR[$month]->getHeureContractant()))
                 ->setTri($this->calculTri($this->aLTIR[$month]->getFat(), $this->aLTIR[$month]->getPdc(), $this->aLTIR[$month]->getLti(), $this->aLTIR[$month]->getMt(), $this->aLTIR[$month]->getRwc()))
               ;
            $this->allTrir[$yearTrir][$month] = $trir;
            $this->allLtir[$yearTrir][$month] = $this->aLTIR[$month];
        }
        return $this;
    }
    
    private function prepareData(){
        $parameters = $this->getParameterLimits($this->dateStart,$this->dateEnd);
        //init kpihse for 1 year
        for($month = $parameters['start'];$month <= $parameters['limit']; $month++){
            $this->aTRIR[$month] = new TRIR();
            $this->aTRIR[$month]->setDate(new \DateTime($parameters['year'] . "-$month-" . self::MONTH_DAY_START));
            $this->aLTIR[$month] = new LTIR();
            $this->aLTIR[$month]->setDate(new \DateTime($parameters['year'] . "-$month-" . self::MONTH_DAY_START)); 
            $this->monthHeaders[$month] = new \DateTime($parameters['year'] . "-$month-" . self::MONTH_DAY_START);
        }
        // go step by step
        $this->countEventsWithCorporelRelationship();
        $this->prepare12Months();
        $this->prepare24Months();
        $this->setMatrixValue();
    }

    private function calculFar($fa,$heureLpsa,$heureContractant){
        if(($heureLpsa+$heureContractant)!=0){
            return $fa*1000000/($heureLpsa+$heureContractant);
        }
        return 0;
    }

    private function calculTri($fat,$pdc,$lti,$mt,$rwc){
        return $fat+$pdc+$lti+$mt+$rwc;
    }
}