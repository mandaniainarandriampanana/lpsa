<?php

namespace Lpsa\AppBundle\Statistic\Model;

class TRIR{

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

    private $objectifTrir = 0.00;

    private $allTrir;
    
    private $latest12Months = array();

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
    
    public function setObjectifTrir($objectifTrir){
        $this->objectifTrir = $objectifTrir;
        return $this;
    }
    
    public function getObjectifTrir(){
        return $this->objectifTrir;
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

    public function getTRIR(){
        $div = $this->getHeureLpsa() + $this->getHeureContractant();
        if($div === 0){
            return 0;
        }
        return (($this->getFat() + $this->getPdc() + $this->getLti()) * 1000000) / $div;
    }

    public function setLatest12Months($latest12Months){
        $this->latest12Months = $latest12Months;
        return $this;
    }

    public function getLatest12Months(){
        return $this->latest12Months;
    }

    public function get12MonthsTRIR($month){
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
            foreach($arrays as $m => $trir){
                if($increment){
                    if(($m >= $latestMonth) && ($inverseCount <= 12)){
                        $sum += $trir->getFat() + $trir->getPdc() + $trir->getLti() + $trir->getMt();
                        $sumDiv += $trir->getHeureLpsa() + $trir->getHeureContractant();
                        $count++; 
                        $inverseCount++;
                    } 
                } else {
                    if(($m <= $latestMonth) && ($inverseCount >= 1)){
                        $sum += $trir->getFat() + $trir->getPdc() + $trir->getLti() + $trir->getMt();
                        $sumDiv += $trir->getHeureLpsa() + $trir->getHeureContractant();
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
                foreach($arrays as $m => $trir){
                    if($count === 12){
                        break;
                    }
                    if($m < $month){
                        $sum += $trir->getFat() + $trir->getPdc() + $trir->getLti() + $trir->getMt();
                        $sumDiv += $trir->getHeureLpsa() + $trir->getHeureContractant();
                        $count++;       
                    } 
                }
            }
            $sum += $this->getFat() + $this->getPdc() + $this->getLti() + $this->getMt();
            $sumDiv += $this->getHeureLpsa() + $this->getHeureContractant();            
            if($sumDiv === 0){
                return 0;
            }
            
            return ($sum *1000000) / $sumDiv;
        }
        return 0;
    }
    
    public function get12MonthsFar($month){
        $far = 0;
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
            foreach($arrays as $m => $trir){
                if($increment){
                    if(($m >= $latestMonth) && ($inverseCount <= 12)){
                        $far += $trir->getFar();
                        $count++; 
                        $inverseCount++;
                    } 
                } else {
                    if(($m <= $latestMonth) && ($inverseCount >= 1)){
                        $far += $trir->getFar();
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
                foreach($arrays as $m => $trir){
                    if($count === 12){
                        break;
                    }
                    if($m < $month){
                        $far += $trir->getFar();
                        $count++;       
                    } 
                }
            }
            $far += $this->getFar();
        }
        return $far;
    }

    public function setAllTrir($allTrir){
        $this->allTrir = $allTrir;
        return $this;
    }

    public function getAllTrir(){
        return $this->allTrir;
    }
}