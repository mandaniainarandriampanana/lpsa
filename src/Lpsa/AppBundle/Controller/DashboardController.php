<?php
namespace Lpsa\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Lpsa\CoreBundle\Controller\CoreController;

class DashboardController extends CoreController{
    public function indexAction(Request $request){
        $manager = $this->getDashboardManager();
        $lastTenEvent = $manager->getLastEvent(10);
        $nbEvent = $manager->countAllEvents();
        /**
         * change these arguments when ids change
         */
        $nbEventZoneSud = $manager->countAllZoneEvent(1);
        $nbEventZoneNord = $manager->countAllZoneEvent(2);  //DepotCategorie
        $nbEventSiege = $manager->countAllZoneEvent(3);
        
        $nbEventHasCategorieAccident = $manager->countEventByCategorie(1);
        $nbEventHasCategoriePresqueAccident = $manager->countEventByCategorie(2);
        $nbEventHasCategorieComportementNonSecuritaire = $manager->countEventByCategorie(3); // EvenementCategorie
        $nbEventHasCategorieSituationDangereuse = $manager->countEventByCategorie(4);
        $nbEventHasCategorieDysfonctionnementsDeMateriels = $manager->countEventByCategorie(5);
        
        $nbEventHasGraviteCatastrophique = $manager->countEventByGravite(1);
        $nbEventHasGraviteMajeur = $manager->countEventByGravite(3);
        $nbEventHasGraviteSerieux = $manager->countEventByGravite(4);       // Gravité
        $nbEventHasGraviteModere = $manager->countEventByGravite(5);
        $nbEventHasGraviteMineur = $manager->countEventByGravite(6);
        
        $nbEventHasStatutEnCours = $manager->countEventByStatut(1);         // evenementstatut
        $nbEventHasStatutCloture = $manager->countEventByStatut(2);
        $indiceReporting = $manager->getIndiceReporting();
        
        $nbEventUpdated = $manager->countEventUpdated();
        return $this->render('LpsaAppBundle:Dashboard:index.html.twig',array(
            'lastTenEvent' => $lastTenEvent,
            'nbEvent' => $nbEvent,
            'nbEventZoneSud' => $nbEventZoneSud,'nbEventZoneNord' => $nbEventZoneNord,'nbEventSiege' => $nbEventSiege,
            'nbEventHasCategorieAccident' => $nbEventHasCategorieAccident,
            'nbEventHasCategoriePresqueAccident' => $nbEventHasCategoriePresqueAccident,
            'nbEventHasCategorieComportementNonSecuritaire' => $nbEventHasCategorieComportementNonSecuritaire,
            'nbEventHasCategorieSituationDangereuse' => $nbEventHasCategorieSituationDangereuse,
            'nbEventHasCategorieDysfonctionnementsDeMateriels' => $nbEventHasCategorieDysfonctionnementsDeMateriels,
            'nbEventHasGraviteCatastrophique' => $nbEventHasGraviteCatastrophique,
            'nbEventHasGraviteMajeur' => $nbEventHasGraviteMajeur,
            'nbEventHasGraviteSerieux' => $nbEventHasGraviteSerieux,
            'nbEventHasGraviteModere' => $nbEventHasGraviteModere,
            'nbEventHasGraviteMineur' => $nbEventHasGraviteMineur,
            'nbEventHasStatutEnCours' => $nbEventHasStatutEnCours,
            'nbEventHasStatutCloture' => $nbEventHasStatutCloture,
            'nbEventUpdated' => $nbEventUpdated,
            'chart' => $this->getChart(null,350,350),
            'indiceReporting' => $indiceReporting
        ));
    }
    public function getDashboardManager(){
        return $this->get('app.dashboard.manager');
    }
}
