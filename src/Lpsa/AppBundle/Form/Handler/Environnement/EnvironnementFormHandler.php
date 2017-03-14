<?php

namespace Lpsa\AppBundle\Form\Handler\Environnement;

use Lpsa\AppBundle\Entity\Environnement;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class EnvironnementFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractEnvironnementFormHandlerStrategy
     */
    protected $environnementFormHandlerStrategy;
    
    /**
     * @var AbstractEnvironnementFormHandlerStrategy
     */
    protected $newEnvironnementFormHandlerStrategy;
    
    /**
     * @var AbstractEnvironnementFormHandlerStrategy
     */
    protected $updateEnvironnementFormHandlerStrategy;
    
    public function setNewEnvironnementFormHandlerStrategy(AbstractEnvironnementFormHandlerStrategy $environnementFormHandlerStrategy) {
        $this->newEnvironnementFormHandlerStrategy = $environnementFormHandlerStrategy;
    }
    
    public function setUpdateEnvironnementFormHandlerStrategy(AbstractEnvironnementFormHandlerStrategy $environnementFormHandlerStrategy) {
        $this->updateEnvironnementFormHandlerStrategy = $environnementFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param Environnement $environnement
     * @return Environnement
     */
    public function processForm(Environnement $environnement = null){
        if (is_null($environnement)){ 
            $environnement = new Environnement();
            $this->environnementFormHandlerStrategy = $this->newEnvironnementFormHandlerStrategy;
        } else {
            $this->environnementFormHandlerStrategy = $this->updateEnvironnementFormHandlerStrategy;
        }
        return $environnement;
    }
    
    public function handleForm(FormInterface $form, Environnement $environnement, Request $request)
    {
        if (
            (null === $environnement->getId() && $request->isMethod('POST'))
            || (null !== $environnement->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->environnementFormHandlerStrategy->handleForm($request, $environnement);
 
            return true;
        }
        return false;
    }
 
    public function createForm(Environnement $environnement)
    {
        return $this->environnementFormHandlerStrategy->createForm($environnement);
    }
 
    public function createView()
    {
        return $this->environnementFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
