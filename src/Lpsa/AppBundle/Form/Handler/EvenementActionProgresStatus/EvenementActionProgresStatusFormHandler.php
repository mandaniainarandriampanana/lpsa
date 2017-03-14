<?php

namespace Lpsa\AppBundle\Form\Handler\EvenementActionProgresStatus;

use Lpsa\AppBundle\Entity\EvenementActionProgresStatus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class EvenementActionProgresStatusFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractEvenementActionProgresStatusFormHandlerStrategy
     */
    protected $evenementactionprogresstatusFormHandlerStrategy;
    
    /**
     * @var AbstractEvenementActionProgresStatusFormHandlerStrategy
     */
    protected $newEvenementActionProgresStatusFormHandlerStrategy;
    
    /**
     * @var AbstractEvenementActionProgresStatusFormHandlerStrategy
     */
    protected $updateEvenementActionProgresStatusFormHandlerStrategy;
    
    public function setNewEvenementActionProgresStatusFormHandlerStrategy(AbstractEvenementActionProgresStatusFormHandlerStrategy $evenementactionprogresstatusFormHandlerStrategy) {
        $this->newEvenementActionProgresStatusFormHandlerStrategy = $evenementactionprogresstatusFormHandlerStrategy;
    }
    
    public function setUpdateEvenementActionProgresStatusFormHandlerStrategy(AbstractEvenementActionProgresStatusFormHandlerStrategy $evenementactionprogresstatusFormHandlerStrategy) {
        $this->updateEvenementActionProgresStatusFormHandlerStrategy = $evenementactionprogresstatusFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param EvenementActionProgresStatus $evenementactionprogresstatus
     * @return EvenementActionProgresStatus
     */
    public function processForm(EvenementActionProgresStatus $evenementactionprogresstatus = null){
        if (is_null($evenementactionprogresstatus)){ 
            $evenementactionprogresstatus = new EvenementActionProgresStatus();
            $this->evenementactionprogresstatusFormHandlerStrategy = $this->newEvenementActionProgresStatusFormHandlerStrategy;
        } else {
            $this->evenementactionprogresstatusFormHandlerStrategy = $this->updateEvenementActionProgresStatusFormHandlerStrategy;
        }
        return $evenementactionprogresstatus;
    }
    
    public function handleForm(FormInterface $form, EvenementActionProgresStatus $evenementactionprogresstatus, Request $request)
    {
        if (
            (null === $evenementactionprogresstatus->getId() && $request->isMethod('POST'))
            || (null !== $evenementactionprogresstatus->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->evenementactionprogresstatusFormHandlerStrategy->handleForm($request, $evenementactionprogresstatus);
 
            return true;
        }
        return false;
    }
 
    public function createForm(EvenementActionProgresStatus $evenementactionprogresstatus)
    {
        return $this->evenementactionprogresstatusFormHandlerStrategy->createForm($evenementactionprogresstatus);
    }
 
    public function createView()
    {
        return $this->evenementactionprogresstatusFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
