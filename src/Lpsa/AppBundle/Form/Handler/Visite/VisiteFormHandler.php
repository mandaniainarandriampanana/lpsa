<?php

namespace Lpsa\AppBundle\Form\Handler\Visite;

use Lpsa\AppBundle\Entity\Visite;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class VisiteFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractVisiteFormHandlerStrategy
     */
    protected $visiteFormHandlerStrategy;
    
    /**
     * @var AbstractVisiteFormHandlerStrategy
     */
    protected $newVisiteFormHandlerStrategy;
    
    /**
     * @var AbstractVisiteFormHandlerStrategy
     */
    protected $updateVisiteFormHandlerStrategy;
    
    public function setNewVisiteFormHandlerStrategy(AbstractVisiteFormHandlerStrategy $visiteFormHandlerStrategy) {
        $this->newVisiteFormHandlerStrategy = $visiteFormHandlerStrategy;
    }
    
    public function setUpdateVisiteFormHandlerStrategy(AbstractVisiteFormHandlerStrategy $visiteFormHandlerStrategy) {
        $this->updateVisiteFormHandlerStrategy = $visiteFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param Visite $visite
     * @return Visite
     */
    public function processForm(Visite $visite = null){
        if (is_null($visite)){ 
            $visite = new Visite();
            $this->visiteFormHandlerStrategy = $this->newVisiteFormHandlerStrategy;
        } else {
            $this->visiteFormHandlerStrategy = $this->updateVisiteFormHandlerStrategy;
        }
        return $visite;
    }
    
    public function handleForm(FormInterface $form, Visite $visite, Request $request)
    {
        if (
            (null === $visite->getId() && $request->isMethod('POST'))
            || (null !== $visite->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->visiteFormHandlerStrategy->handleForm($request, $visite);
 
            return true;
        }
        return false;
    }
 
    public function createForm(Visite $visite)
    {
        return $this->visiteFormHandlerStrategy->createForm($visite);
    }
 
    public function createView()
    {
        return $this->visiteFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
