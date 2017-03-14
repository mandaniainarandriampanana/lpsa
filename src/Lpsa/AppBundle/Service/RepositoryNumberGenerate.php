<?php

namespace Lpsa\AppBundle\Service;

use Lpsa\AppBundle\Entity\Manager\Interfaces\EvenementManagerInterface;
use Lpsa\AppBundle\Entity\Depot;

class RepositoryNumberGenerate {
    
    /**
     *
     * @var EvenementManagerInterface 
     */
    private $eventManager;
    
    /**
     * 
     * @param EvenementManagerInterface $eventManager
     */
    public function __construct(EvenementManagerInterface $eventManager){
        $this->eventManager = $eventManager;
    }
    
    public function generate(Depot $depot,$eventId = null){
        $number = 0;
        $events = $this->eventManager->getRepository()->findAllEvennementByDepot($depot->getId());
        if(empty($events)){
            $number = $this->getDefaultNumSaved($depot);
        } else {
            $lastNum = $this->getLatestNumSaved($events,$eventId);
            if($lastNum === 0){
                $lastNum = $this->getDefaultNumSaved($depot);
            }
            $tmpNumber = intval($lastNum) + 1;
            $number = $depot->getSigle() . '-' . $this->formatLatestNum($tmpNumber) . '/' .  date('Y');
        }
        return $number;
    }
    
    public function checkNumber($number,Depot $depot,$eventId){
        $events = $this->eventManager->getRepository()->findByNumeroEnregistrement($number);
        if(count($events) === 1){
            return $number;
        }
        return $this->generate($depot,$eventId);
    }
    
    private function formatLatestNum($numero){
        if($numero < 10){
            return '00' . $numero;
        } 
        return '0' . $numero;
    }
    private function getLatestNumSaved($evenements,$event){
        $numeroEnr = array();
        $numero = 0;
        foreach($evenements as $evenement){
            if(!empty($event) && ($event == $evenement->getId())){
                continue;
            }
            $num = $evenement->getNumeroEnregistrement();
            if(preg_match("/-([0-9]*)\/([0-9]*)/", $num, $matches)){
                if($matches[2] >= date('Y')){
                    $numeroEnr[$matches[2]][] = $matches[1];                        
                }
            }
        }
        if(!empty($numeroEnr)){
            ksort($numeroEnr);
            reset($numeroEnr);
            $latest = end($numeroEnr);
            sort($latest);
            reset($latest);
            $numero = end($latest);
        }
        return $numero;
    }
    
    private function getDefaultNumSaved($depot){
        return $depot->getSigle() . '-001/' . date('Y');
    }
}
