<?php

namespace Lpsa\AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Lpsa\AppBundle\Entity\Observable\EventObservable;

class ServiceManagerEvent extends Event{
    
    private $eventObservable;
    
    public function __construct(EventObservable $eventObservable) {
        $this->eventObservable = $eventObservable;
    }
    
    public function getEvent()
    {
        return $this->eventObservable->getEvent();
    }
}
