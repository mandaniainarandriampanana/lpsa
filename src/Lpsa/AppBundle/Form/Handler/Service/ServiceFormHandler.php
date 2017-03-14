<?php

namespace Lpsa\AppBundle\Form\Handler\Service;

use Lpsa\AppBundle\Entity\Service;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class ServiceFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractServiceFormHandlerStrategy
     */
    protected $serviceFormHandlerStrategy;
    
    /**
     * @var AbstractServiceFormHandlerStrategy
     */
    protected $newServiceFormHandlerStrategy;
    
    /**
     * @var AbstractServiceFormHandlerStrategy
     */
    protected $updateServiceFormHandlerStrategy;
    
    public function setNewServiceFormHandlerStrategy(AbstractServiceFormHandlerStrategy $serviceFormHandlerStrategy) {
        $this->newServiceFormHandlerStrategy = $serviceFormHandlerStrategy;
    }
    
    public function setUpdateServiceFormHandlerStrategy(AbstractServiceFormHandlerStrategy $serviceFormHandlerStrategy) {
        $this->updateServiceFormHandlerStrategy = $serviceFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param Service $service
     * @return Service
     */
    public function processForm(Service $service = null){
        if (is_null($service)){ 
            $service = new Service();
            $this->serviceFormHandlerStrategy = $this->newServiceFormHandlerStrategy;
        } else {
            $this->serviceFormHandlerStrategy = $this->updateServiceFormHandlerStrategy;
        }
        return $service;
    }
    
    public function handleForm(FormInterface $form, Service $service, Request $request)
    {
        if (
            (null === $service->getId() && $request->isMethod('POST'))
            || (null !== $service->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->serviceFormHandlerStrategy->handleForm($request, $service);
 
            return true;
        }
        return false;
    }
 
    public function createForm(Service $service)
    {
        return $this->serviceFormHandlerStrategy->createForm($service);
    }
 
    public function createView()
    {
        return $this->serviceFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
