<?php

namespace Lpsa\AppBundle\Form\Handler\ImpactClient;

use Lpsa\AppBundle\Entity\ImpactClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class ImpactClientFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractImpactClientFormHandlerStrategy
     */
    protected $impactclientFormHandlerStrategy;
    
    /**
     * @var AbstractImpactClientFormHandlerStrategy
     */
    protected $newImpactClientFormHandlerStrategy;
    
    /**
     * @var AbstractImpactClientFormHandlerStrategy
     */
    protected $updateImpactClientFormHandlerStrategy;
    
    public function setNewImpactClientFormHandlerStrategy(AbstractImpactClientFormHandlerStrategy $impactclientFormHandlerStrategy) {
        $this->newImpactClientFormHandlerStrategy = $impactclientFormHandlerStrategy;
    }
    
    public function setUpdateImpactClientFormHandlerStrategy(AbstractImpactClientFormHandlerStrategy $impactclientFormHandlerStrategy) {
        $this->updateImpactClientFormHandlerStrategy = $impactclientFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param ImpactClient $impactclient
     * @return ImpactClient
     */
    public function processForm(ImpactClient $impactclient = null){
        if (is_null($impactclient)){ 
            $impactclient = new ImpactClient();
            $this->impactclientFormHandlerStrategy = $this->newImpactClientFormHandlerStrategy;
        } else {
            $this->impactclientFormHandlerStrategy = $this->updateImpactClientFormHandlerStrategy;
        }
        return $impactclient;
    }
    
    public function handleForm(FormInterface $form, ImpactClient $impactclient, Request $request)
    {
        if (
            (null === $impactclient->getId() && $request->isMethod('POST'))
            || (null !== $impactclient->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->impactclientFormHandlerStrategy->handleForm($request, $impactclient);
 
            return true;
        }
        return false;
    }
 
    public function createForm(ImpactClient $impactclient)
    {
        return $this->impactclientFormHandlerStrategy->createForm($impactclient);
    }
 
    public function createView()
    {
        return $this->impactclientFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
