<?php

namespace Lpsa\AppBundle\Form\Handler\IndicateurTransport;

use Lpsa\AppBundle\Entity\IndicateurTransport;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class IndicateurTransportFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractIndicateurTransportFormHandlerStrategy
     */
    protected $indicateurTransportFormHandlerStrategy;
    
    /**
     * @var AbstractIndicateurTransportFormHandlerStrategy
     */
    protected $newIndicateurTransportFormHandlerStrategy;
    
    /**
     * @var AbstractIndicateurTransportFormHandlerStrategy
     */
    protected $updateIndicateurTransportFormHandlerStrategy;
    
    public function setNewIndicateurTransportFormHandlerStrategy(AbstractIndicateurTransportFormHandlerStrategy $indicateurTransportFormHandlerStrategy) {
        $this->newIndicateurTransportFormHandlerStrategy = $indicateurTransportFormHandlerStrategy;
    }
    
    public function setUpdateIndicateurTransportFormHandlerStrategy(AbstractIndicateurTransportFormHandlerStrategy $indicateurTransportFormHandlerStrategy) {
        $this->updateIndicateurTransportFormHandlerStrategy = $indicateurTransportFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param IndicateurTransport $indicateurTransport
     * @return IndicateurTransport
     */
    public function processForm(IndicateurTransport $indicateurTransport = null){
        if (is_null($indicateurTransport)){ 
            $indicateurTransport = new IndicateurTransport();
            $this->indicateurTransportFormHandlerStrategy = $this->newIndicateurTransportFormHandlerStrategy;
        } else {
            $this->indicateurTransportFormHandlerStrategy = $this->updateIndicateurTransportFormHandlerStrategy;
        }
        return $indicateurTransport;
    }
    
    public function handleForm(FormInterface $form, IndicateurTransport $indicateurTransport, Request $request)
    {
        if (
            (null === $indicateurTransport->getId() && $request->isMethod('POST'))
            || (null !== $indicateurTransport->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->indicateurTransportFormHandlerStrategy->handleForm($request, $indicateurTransport);
 
            return true;
        }
        return false;
    }
 
    public function createForm(IndicateurTransport $indicateurTransport)
    {
        return $this->indicateurTransportFormHandlerStrategy->createForm($indicateurTransport);
    }
 
    public function createView()
    {
        return $this->indicateurTransportFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
