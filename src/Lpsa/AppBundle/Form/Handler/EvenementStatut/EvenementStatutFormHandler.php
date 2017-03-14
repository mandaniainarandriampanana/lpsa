<?php

namespace Lpsa\AppBundle\Form\Handler\EvenementStatut;

use Lpsa\AppBundle\Entity\EvenementStatut;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class EvenementStatutFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractEvenementStatutFormHandlerStrategy
     */
    protected $evenementStatutFormHandlerStrategy;
    
    /**
     * @var AbstractEvenementStatutFormHandlerStrategy
     */
    protected $newEvenementStatutFormHandlerStrategy;
    
    /**
     * @var AbstractEvenementStatutFormHandlerStrategy
     */
    protected $updateEvenementStatutFormHandlerStrategy;
    
    public function setNewEvenementStatutFormHandlerStrategy(AbstractEvenementStatutFormHandlerStrategy $evenementStatutFormHandlerStrategy) {
        $this->newEvenementStatutFormHandlerStrategy = $evenementStatutFormHandlerStrategy;
    }
    
    public function setUpdateEvenementStatutFormHandlerStrategy(AbstractEvenementStatutFormHandlerStrategy $evenementStatutFormHandlerStrategy) {
        $this->updateEvenementStatutFormHandlerStrategy = $evenementStatutFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param EvenementStatut $evenementStatut
     * @return EvenementStatut
     */
    public function processForm(EvenementStatut $evenementStatut = null){
        if (is_null($evenementStatut)){ 
            $evenementStatut = new EvenementStatut();
            $this->evenementStatutFormHandlerStrategy = $this->newEvenementStatutFormHandlerStrategy;
        } else {
            $this->evenementStatutFormHandlerStrategy = $this->updateEvenementStatutFormHandlerStrategy;
        }
        return $evenementStatut;
    }
    
    public function handleForm(FormInterface $form, EvenementStatut $evenementStatut, Request $request)
    {
        if (
            (null === $evenementStatut->getId() && $request->isMethod('POST'))
            || (null !== $evenementStatut->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->evenementStatutFormHandlerStrategy->handleForm($request, $evenementStatut);
 
            return true;
        }
        return false;
    }
 
    public function createForm(EvenementStatut $evenementStatut)
    {
        return $this->evenementStatutFormHandlerStrategy->createForm($evenementStatut);
    }
 
    public function createView()
    {
        return $this->evenementStatutFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
