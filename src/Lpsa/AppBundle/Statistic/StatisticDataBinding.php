<?php 

namespace Lpsa\AppBundle\Statistic;

//relationship with modeling database and excel
class StatisticDataBinding{

    const FAT = 1; //Entity TypeCorporel id=1

    const LTI = 2; //Entity TypeCorporel id=2

    const ACCIDENT_NON_STOP = 3; //Entity TypeCorporel id=3

    const RWC = 6; //Entity Corporel id=6

    const MT  = 7; //Entity Corporel id=7

    const FA  = 9; //Entity Corporel id=9

    const DEPOT_SIEGE = 3; //Entity DepotCategorie id=3

    const ZONE_ETANCHE = 1; //Entity TypeEnvironnement id=1

    const ZONE_NON_ETANCHE = 2; //Entity TypeEnvironnement id=2

    const ENVIRONMENT_ZE_LESS_1_M3 = 1; //Entity Environnement id=1

    const ENVIRONMENT_ZNE_LESS_1_M3 = 6; //Entity Environnement id=1

    const MONTH_DAY_START = 26;//eg: 26/11

    const MONTH_DAY_END = 25;//eg 25/12

    const PDC = 8; //Entity Corporel id=8

    const HOUR_CATEGORY_LPSA = 1; //Entity HeureTravailCategorie id=1

    const HOUR_CATEGORY_CONTRACTANT = 2; //Entity HeureTravailCategorie id=2 

    const PRESQUE_ACCIDENT = 2;//categorie id=2

    const SITUATION_DANGEREUSE = 4;//categorie id=4

    const INCIDENT_POTENTIEL = 3;

    const STATUT_CLOTURE = 2;// entity EvenementStatut id=2

    const STATUT_NON_CLOTURE = 2;// entity EvenementStatut id=3
    
    protected $nbAvecArret = array(3,4,5);//Entity Corporel Ids

    protected $categorie = array(
        'accident' => array(1),
        'incident' => array(1,2,3,4,5)
    ); //Entity EvenementCategorie Ids 

    protected $typeAccident = array(
        'maritime' => 1,
        'terrestre' => 2
    );//Entity TypeAccident Ids

    protected $typeSituationDangereuse = array(
        'agression' => 1,
        'vol' => 2,
        'intrusion' => 3
    );//Entity TypeSituationDangereuse Ids


    protected $fuiteflexibleIds = array(1,2,6,7);//entity Environnement Ids

}