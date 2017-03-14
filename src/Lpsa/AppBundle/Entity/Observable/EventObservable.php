<?php

namespace Lpsa\AppBundle\Entity\Observable;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Lpsa\AppBundle\Event\ServiceManagerEvent;
use Lpsa\AppBundle\LpsaAppEventObserver;
use Lpsa\AppBundle\Entity\Evenement;

class EventObservable {
    
    private $dispatcher;
    private $event;
    
    public function getEvent(){
        return $this->event;
    }
    
    public function setDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    
    public function setEvent(Evenement $event)
    {
        $this->event = $event;
        $serviceManagerEvent= new ServiceManagerEvent($this);
        $this->dispatcher->dispatch(LpsaAppEventObserver::MANAGER_SERVICE_SET, $serviceManagerEvent);
    }
}
