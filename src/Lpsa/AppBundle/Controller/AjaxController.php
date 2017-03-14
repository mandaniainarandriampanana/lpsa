<?php

namespace Lpsa\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Lpsa\CoreBundle\Controller\CoreController;

/**
 * Ajax controller.
 *
 */
class AjaxController extends CoreController
{
    
    public function getCorporelAction(Request $request){
        $out = array();
        $corporels = $this->getCorporelManager()->getRepository()->findAllCorporelByTypeCorporel($request->query->get('id'));
        foreach($corporels as $corporel){
            $out[] = array(
                'id' => $corporel->getId(),
                'value' => $corporel->getLibelle()
            );
        }
        $response = new JsonResponse($out);
        return $response;
    }
    
    public function getDepotAction(Request $request){
        $out = array();
        $depots = $this->getDepotManager()->getRepository()->findAllDepotByDepotCategorie($request->query->get('id'));
        foreach($depots as $depot){
            $out[] = array(
                'id' => $depot->getId(),
                'value' => $depot->getLibelle()
            );
        }
        $response = new JsonResponse($out);
        return $response;
    }
    
     public function getDepartementAction(Request $request){
        $out = array();
        $departements = $this->getDepartementManager()->getRepository()->findAllDepartementsByDirection($request->query->get('id'));
        foreach($departements as $departement){
            $out[] = array(
                'id' => $departement->getId(),
                'value' => $departement->getLibelle()
            );
        }
        $response = new JsonResponse($out);
        return $response;
    }
    
    public function getEnvironnementAction(Request $request){
        $out = array();
        $environements = $this->getEnvironnementManager()->getRepository()->findAllEnvironnementByTypeEnvironnement($request->query->get('id'));
        foreach($environements as $environement){
            $out[] = array(
                'id' => $environement->getId(),
                'value' => $environement->getLibelle()
            );
        }
        $response = new JsonResponse($out);
        return $response;
    }
    
    public function getServiceAction(Request $request){
        $out = array();
        $services = $this->getServiceManager()->getRepository()->findAllServicesByDepartement($request->query->get('id'));
        foreach($services as $service){
            $out[] = array(
                'id' => $service->getId(),
                'value' => $service->getLibelle()
            );
        }
        $response = new JsonResponse($out);
        return $response;
    }
    
    public function getMaterielAction(Request $request){
        $out = array();
        $materiels = $this->getMaterielManager()->getRepository()->findAllMaterielByTypeMateriel($request->query->get('id'));
        foreach($materiels as $materiel){
            $out[] = array(
                'id' => $materiel->getId(),
                'value' => $materiel->getLibelle()
            );
        }
        $response = new JsonResponse($out);
        return $response;
    }
    
    //ajax get gravity label
    public function getGravityAction(Request $request){
        $corporelId = $request->query->get('corporel');
        $materielId = $request->query->get('materiel');
        $environnementId = $request->query->get('environnement');
        $impactmediatiqueId = $request->query->get('impactmediatique');
        $impactclientId = $request->query->get('impactclient');
        $dysfonctionnementId = $request->query->get('dysfonctionnement');
        $corporel = $materiel = $environnement = $impactmediatique = $impactclient = $dysfonctionnement = null;
        if($corporelId){
            $corporel = $this->get('app.corporel.manager')->getRepository()->findOneById($corporelId);            
        }
        if($materielId){
            $materiel = $this->get('app.materiel.manager')->getRepository()->findOneById($materielId);            
        }
        if($environnementId){
            $environnement = $this->get('app.environnement.manager')->getRepository()->findOneById($environnementId);            
        }
        if($impactmediatiqueId){
            $impactmediatique = $this->get('app.impactmediatique.manager')->getRepository()->findOneById($impactmediatiqueId);            
        }
        if($impactclientId){
            $impactclient = $this->get('app.impactclient.manager')->getRepository()->findOneById($impactclientId);            
        }
        if($dysfonctionnementId){
            $dysfonctionnement = $this->get('app.dysfonctionnement.manager')->getRepository()->findOneById($dysfonctionnementId);            
        }
        $gravity = $this->getGravity($corporel, $materiel, $environnement, $impactmediatique, $impactclient, $dysfonctionnement);
        $response = new JsonResponse(array(
            'value' => ($gravity && is_object($gravity)) ? $gravity->getLibelle() : '',
            'id' => ($gravity && is_object($gravity)) ? $gravity->getId() : '',
            'gravityValue' => ($gravity && is_object($gravity)) ? $gravity->getValeur() : '',
        ));
        return $response;
    }
    
    //ajax get repository number
    public function getNumeroEnregistrementAction(Request $request){      
        $depot = $this->get('app.depot.manager')->getRepository()->findOneById($request->query->get('id'));
        $out = array();
        if(empty($depot)){
            $out = $this->getRepositoryNumber('');
        } else {
            $number = $this->get('app.repository_number_generate')->generate($depot,$request->query->get('event'));
            if($number === 0){
                $out = $this->getRepositoryNumber('');
            } else {
                $out = $this->getRepositoryNumber($number);
            }            
        }
        $response = new JsonResponse($out);
        return $response;
    }
    public function alldepotAction(Request $request){
        $out = array();
        $depots = $this->getDepotManager()->getRepository()->findAll();
        foreach($depots as $depot){
            $out[] = array(
                'id' => $depot->getId(),
                'value' => $depot->getLibelle()
            );
        }
        $response = new JsonResponse($out);
        return $response;
    }
    private function getRepositoryNumber($value){
        return array(
                'value' => $value
        );
    }
}
