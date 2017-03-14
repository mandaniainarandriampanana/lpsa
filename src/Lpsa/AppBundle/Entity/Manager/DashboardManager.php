<?php

namespace Lpsa\AppBundle\Entity\Manager;

use Lpsa\AppBundle\Entity\Manager\EvenementManager;
use Lpsa\AppBundle\Entity\Manager\Interfaces\DepotManagerInterface;
use Lpsa\AppBundle\Statistic\StatisticDataBinding;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class DashboardManager {
    /**
     *
     * @var type EvenementManager
     */
    private $evenementManager;

    private $depotManager;
    /**
     *
     * @var type Evenemements
     */
    private $allEvents;

    private $container;

    private $dateStart;

    private $dateEnd;
    
    
    /**
     * 
     * @param EvenementManager $evenementManager
     */
    public function __construct(EvenementManager $evenementManager,DepotManagerInterface $depotManager, Container $container) {
        $this->evenementManager = $evenementManager;
        $this->depotManager = $depotManager;
        $this->container = $container;
        $now = new \DateTime('now');
        $month = intval($now->format('m'));
        $monthEnd = $now->format('m');
        $isNext = false;
        if(intval($now->format('d')) >= StatisticDataBinding::MONTH_DAY_START && intval($now->format('d')) < 31){
            $monthEnd++;
            $isNext = true;
        }
        if($month === 1 && !$isNext){
            $lastYear = $now->modify('-1 year');
        } else {
            $lastYear = $now;
        }
        if(!$isNext){
            $month--;
        }
        if($month <= 0){
            $month = 12;
        }
        $dateStart = new \DateTime($lastYear->format('Y') . '-'.$month .'-' . StatisticDataBinding::MONTH_DAY_START);
        $this->dateStart = $dateStart;
        $now = new \DateTime('now');
        $dateEnd = new \DateTime($now->format('Y') . '-' . $monthEnd . '-' . StatisticDataBinding::MONTH_DAY_END);
        $this->dateEnd = $dateEnd;
        $this->allEvents = $this->evenementManager->getRepository()->findAllDescByDateEmission($dateStart,$dateEnd);
    }

    public function getIndiceReporting(){
        $depots = $this->depotManager->getRepository()->findAll();
        $eventsPerDepot = array();
        $ir = array();
        foreach ($this->allEvents as $event){
            $tmp = array();
            $depot = $event->getDepot();
            if(array_key_exists($depot->getId(),$eventsPerDepot)){
                $tmp = $eventsPerDepot[$depot->getId()];
            }
            $tmp[] = $event;
            $eventsPerDepot[$event->getDepot()->getId()] = $tmp;
        }
        $userManager = $this->container->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        $usersPerDepot = array();
        foreach($users as $user){
            $groups = $user->getGroups();
            foreach($groups as $group){
                $dep = $group->getDepot();
                if($dep){
                   $usersPerDepot[$dep->getId()] = $user; 
                }
            }
        }
        $now = new \DateTime('now');
        if(intval($now->format('d')) >= StatisticDataBinding::MONTH_DAY_START && intval($now->format('m')) == 12){
            $compareDate = new \DateTime($now->format('Y') . '-12-' . StatisticDataBinding::MONTH_DAY_START);
        } else {
            $tmpDate = new \DateTime($now->format('Y') . '-12-' . StatisticDataBinding::MONTH_DAY_START);
            $compareDate = $tmpDate->modify('-1 year');
        }
        $interval = $now->diff($compareDate);
        $days = $interval->days;
        foreach($depots as $depot){
            if(array_key_exists($depot->getId(),$eventsPerDepot) && array_key_exists($depot->getId(),$usersPerDepot)){
                $tmp = $eventsPerDepot[$depot->getId()];
                $tmpUsers = $usersPerDepot[$depot->getId()];
                $value = (365 / $days) * (count($tmp) / count($tmpUsers));
                $ir[] = array(
                    'depot' => $depot,
                    'value' => $value
                );
            } else {
                $ir[] = array(
                    'depot' => $depot,
                    'value' => 0
                );
            }
        }
        return $ir;
    }
    /**
     * 
     * @param type $allEvents
     * @return int
     */
    public function countAllEvents(){
        $i=0;
        foreach ($this->allEvents as $event){
            $i++;
        }
        return $i;
    }
    /**
     * 
     * @param type $nbResults
     * @return array
     */
    public function getLastEvent($nbResults){
        if($nbResults < $this->countAllEvents()){
            $result = array();
            for($i=0;$i<$nbResults;$i++){
                array_push($result,$this->allEvents[$i]);
            }
            return $result;
        }
        return $this->allEvents;
    }
    /**
     * 
     * @param type $id
     * @return int
     */
    public function countAllZoneEvent($id){
        $i=0;
        foreach ($this->allEvents as $event){
            if($event->getDepot()->getDepotCategories()->getId() == $id){
                $i++;
            }
        }
        return $i;
    }
    /**
     * 
     * @param type $id
     * @return int
     */
    public function countEventByCategorie($id){
        $i=0;
        foreach ($this->allEvents as $event){
            if($event->getCategorie()->getId() == $id){
                $i++;
            }
        }
        return $i;
    }
    /**
     * 
     * @param type $id
     * @return int
     */
    public function countEventByGravite($id){
        $i=0;
        foreach ($this->allEvents as $event){
            if($event->getGravite()!=null){
                if($event->getGravite()->getId() == $id){
                    $i++;
                }
            }
        }
        return $i;
    }
    /**
     * 
     * @param type $id
     * @return int
     */
    public function countEventByStatut($id){
        $i=0;
        foreach ($this->allEvents as $event){
            if($event->getEvenementStatut()->getId() == $id){
                $i++;
            }
        }
        return $i;
    }
    /**
     * 
     * @return int
     */
    public function countEventUpdated(){
        $i=0;
        foreach ($this->allEvents as $event){
            if($event->getDateUpdate() != null){
                $i++;
            }
        }
        return $i;
    }
}
