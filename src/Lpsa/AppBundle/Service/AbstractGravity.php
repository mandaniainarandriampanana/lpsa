<?php

namespace Lpsa\AppBundle\Service;

class AbstractGravity {
    
    /**
     * Get abstract gravity for event
     * @param Corporel $corporel
     * @param Materiel $materiel
     * @param Environnement $environnement
     * @param ImpactMediatique $impactmediatique
     * @param ImpactClient $impactclient
     * @param Dysfonctionnement $dysfonctionnement
     * @return string
     */
    public function getGravity($corporel,$materiel,$environnement,$impactmediatique,$impactclient,$dysfonctionnement){
        return $this->process($corporel, $materiel, $environnement, $impactmediatique, $impactclient, $dysfonctionnement);
    }
    
    /**
     * Get abstract gravity for event
     * @param Corporel $corporel
     * @param Materiel $materiel
     * @param Environnement $environnement
     * @param ImpactMediatique $impactmediatique
     * @param ImpactClient $impactclient
     * @param Dysfonctionnement $dysfonctionnement
     * @return string
     */
    public function getGravityLabel($corporel,$materiel,$environnement,$impactmediatique,$impactclient,$dysfonctionnement){
        $gravity = $this->process($corporel, $materiel, $environnement, $impactmediatique, $impactclient, $dysfonctionnement);
        return ($gravity && is_object($gravity)) ? $gravity->getLibelle() : '';
    }
    
    /**
     * Get abstract gravity for event
     * @param Corporel $corporel
     * @param Materiel $materiel
     * @param Environnement $environnement
     * @param ImpactMediatique $impactmediatique
     * @param ImpactClient $impactclient
     * @param Dysfonctionnement $dysfonctionnement
     * @return string
     */
    protected function process($corporel,$materiel,$environnement,$impactmediatique,$impactclient,$dysfonctionnement){
        $gravities = array();
        $gravity = null;
        if($corporel){
            $gravities[$corporel->getGravite()->getValeur()] = $corporel->getGravite();
        }
        if($materiel){
            $gravities[$materiel->getGravite()->getValeur()] = $materiel->getGravite();
        }
        if($environnement){
            $gravities[$environnement->getGravite()->getValeur()] = $environnement->getGravite();
        }
        if($impactmediatique){
            $gravities[$impactmediatique->getGravite()->getValeur()] = $impactmediatique->getGravite();
        }
        if($impactclient){
            $gravities[$impactclient->getGravite()->getValeur()] = $impactclient->getGravite();
        }
        if($dysfonctionnement){
            $gravities[$dysfonctionnement->getGravite()->getValeur()] = $dysfonctionnement->getGravite();
        }
        if(!empty($gravities)){
            rsort($gravities);
            reset($gravities);
            $gravity = end($gravities);
        }
        return $gravity;
    }
}
