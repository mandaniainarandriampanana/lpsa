<?php

namespace Lpsa\AppBundle\Service;
use Symfony\Component\HttpFoundation\Session\Session;


class FunctionHelper {
    
    public function convertDateFrStringToDateTime($strDate){        
        if(!empty($strDate)){
            list($day, $month, $year) = split('[/.-]', $strDate);
            $dateEn = $year."/".$month."/".$day;
            return new \DateTime($dateEn);
        }
        return null;
    }
    public function sessionHelper($set,$get,$remove,$name,$content){
        $session = new Session();
        if($set){
            $session->set($name,$content);
            return true;
        }
        if($get){
            return $session->get($name);
        }
        if($remove){
            $session->remove($name);
            return true;
        }
    }
    public function FormatDoublon($arrayDoublon){
        $doublonFormated = "";
        foreach($arrayDoublon as $doublons){
            foreach($doublons as $doublon){
            $doublonFormated .= "'".$doublon."',";
            }   
        }
         return rtrim($doublonFormated, ',');

    }
}
