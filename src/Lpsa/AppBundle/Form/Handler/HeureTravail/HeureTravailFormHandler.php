<?php

namespace Lpsa\AppBundle\Form\Handler\HeureTravail;

use Lpsa\AppBundle\Entity\HeureTravail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class HeureTravailFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractHeureTravailFormHandlerStrategy
     */
    protected $heureTravailFormHandlerStrategy;
    
    /**
     * @var AbstractHeureTravailFormHandlerStrategy
     */
    protected $newHeureTravailFormHandlerStrategy;
    
    /**
     * @var AbstractHeureTravailFormHandlerStrategy
     */
    protected $updateHeureTravailFormHandlerStrategy;
    
    public function setNewHeureTravailFormHandlerStrategy(AbstractHeureTravailFormHandlerStrategy $heureTravailFormHandlerStrategy) {
        $this->newHeureTravailFormHandlerStrategy = $heureTravailFormHandlerStrategy;
    }
    
    public function setUpdateHeureTravailFormHandlerStrategy(AbstractHeureTravailFormHandlerStrategy $heureTravailFormHandlerStrategy) {
        $this->updateHeureTravailFormHandlerStrategy = $heureTravailFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param HeureTravail $heureTravail
     * @return HeureTravail
     */
    public function processForm(HeureTravail $heureTravail = null){
        if (is_null($heureTravail)){ 
            $heureTravail = new HeureTravail();
            $this->heureTravailFormHandlerStrategy = $this->newHeureTravailFormHandlerStrategy;
        } else {
            $this->heureTravailFormHandlerStrategy = $this->updateHeureTravailFormHandlerStrategy;
        }
        return $heureTravail;
    }
    
    public function handleForm(FormInterface $form, HeureTravail $heureTravail, Request $request)
    {
        if (
            (null === $heureTravail->getId() && $request->isMethod('POST'))
            || (null !== $heureTravail->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->heureTravailFormHandlerStrategy->handleForm($request, $heureTravail);
 
            return true;
        }
        return false;
    }
 
    public function createForm(HeureTravail $heureTravail)
    {
        return $this->heureTravailFormHandlerStrategy->createForm($heureTravail);
    }
 
    public function createView()
    {
        return $this->heureTravailFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
