<?php

namespace Lpsa\AppBundle\Statistic\Model;

class LTIR{

    private $fat = 0;

    private $pdc = 0;

    private $lti = 0;

    private $mt = 0;

    private $rwc = 0;

    private $fa = 0;

    private $far = 0.00;

    private $tri = 0.00;

    private $heureLpsa = 0;

    private $heureContractant = 0;

    private $objectifLtir = 0.00;

    private $latest12Months = array();

    private $allLtir;

    private $date;
    
    private $matrix;

    public function setMatrix($matrix){
        $this->matrix = $matrix;
        return $this;
    }

    public function getMatrix(){
        return $this->matrix;
    }

    public function setDate($date){
        $this->date = $date;
        return $this;
    }
    
    public function getDate(){
        return $this->date;
    }
    
    public function setFar($far){
        $this->far = $far;
        return $this;
    }
    
    public function getFar(){
        return $this->far;
    }
    
    public function setTri($tri){
        $this->tri = $tri;
        return $this;
    }
    
    public function getTri(){
        return $this->tri;
    }
    
    public function setObjectifLtir($objectifLtir){
        $this->objectifLtir = $objectifLtir;
        return $this;
    }
    
    public function getObjectifLtir(){
        return $this->objectifLtir;
    }
    
    public function setFat($fat){
        $this->fat = $fat;
        return $this;
    }

    public function getFat(){
        return $this->fat;
    }

    public function setPdc($pdc){
        $this->pdc = $pdc;
        return $this;
    }

    public function getPdc(){
        return $this->pdc;
    }

    public function setLti($lti){
        $this->lti = $lti;
        return $this;
    }

    public function getLti(){
        return $this->lti;
    }

    public function setMt($mt){
        $this->mt = $mt;
        return $this;
    }

    public function getMt(){
        return $this->mt;
    }

    public function setRwc($rwc){
        $this->rwc = $rwc;
        return $this;
    }

    public function getRwc(){
        return $this->rwc;
    }

    public function setFa($fa){
        $this->fa = $fa;
        return $this;
    }

    public function getFa(){
        return $this->fa;
    }

    public function setHeureLpsa($heureLpsa){
        $this->heureLpsa = $heureLpsa;
        return $this;
    }

    public function getHeureLpsa(){
        return $this->heureLpsa;
    }

    public function setHeureContractant($heureContractant){
        $this->heureContractant = $heureContractant;
        return $this;
    }

    public function getHeureContractant(){
        return $this->heureContractant;
    }

    public function getLTIR(){
        $div = $this->getHeureLpsa() + $this->getHeureContractant();
        if($div === 0){
            return 0;
        }
        return (($this->getFat() + $this->getPdc() + $this->getLti() + $this->getMt() + $this->getRwc()) * 1000000) / $div;
    }

    public function setLatest12Months($latest12Months){
        $this->latest12Months = $latest12Months;
        return $this;
    }

    public function getLatest12Months(){
        return $this->latest12Months;
    }

    public function get12MonthsLTIR($month){
        $count = 1;
        $latestMonth = $month;
        $year = intval($this->getDate()->format('Y'));
        $yearly = $year;
        for($i = 0;$i < 11; $i++){
            $latestMonth--;
            if($latestMonth < 1){
                $latestMonth = 12;
                $yearly--;
            }
        }
        $sum = 0;
        $sumDiv = 0;
        if(!$this->getMatrix()){
            return 0;
        }
        if(array_key_exists($yearly,$this->getMatrix())){
            $arrays = $this->getMatrix()[$yearly];
            $inverseCount = $latestMonth;
            $increment = false;
            if($latestMonth > $month){
                $increment = true;
            }
            foreach($arrays as $m => $ltir){
                if($increment){
                    if(($m >= $latestMonth) && ($inverseCount <= 12)){
                        $sum += $ltir->getFat() + $ltir->getPdc() + $ltir->getLti();
                        $sumDiv += $ltir->getHeureLpsa() + $ltir->getHeureContractant();
                        $count++; 
                        $inverseCount++;
                    } 
                } else {
                    if(($m <= $latestMonth) && ($inverseCount >= 1)){
                        $sum += $ltir->getFat() + $ltir->getPdc() + $ltir->getLti();
                        $sumDiv += $ltir->getHeureLpsa() + $ltir->getHeureContractant();
                        $count++; 
                        $inverseCount--;
                    } 
                }
            }
            $latestMonth = $inverseCount;
            if($latestMonth === 1){
                $latestMonth = 12;
            } elseif($latestMonth > 12) {
                $latestMonth = 1;
            }
            if($count < 12){
                $arrays = $this->getMatrix()[$year];
                ksort($arrays);
                foreach($arrays as $m => $ltir){
                    if($count === 12){
                        break;
                    }
                    if($m < $month){
                        $sum += $ltir->getFat() + $ltir->getPdc() + $ltir->getLti();
                        $sumDiv += $ltir->getHeureLpsa() + $ltir->getHeureContractant();
                        $count++;        
                    } 
                }
            }
            $sum += $this->getFat() + $this->getPdc() + $this->getLti();
            $sumDiv += $this->getHeureLpsa() + $this->getHeureContractant();
            if($sumDiv === 0){
                return 0;
            }
            return ($sum *1000000) / $sumDiv;
        }
        return 0;
        
    }
    
    public function setAllLtir($allLtir){
        $this->allLtir = $allLtir;
        return $this;
    }

    public function getAllLtir(){
        return $this->allLtir;
    }
}