<?php

namespace Lpsa\AppBundle\Form\Handler\Dysfonctionnement;

use Lpsa\AppBundle\Entity\Dysfonctionnement;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class DysfonctionnementFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractDysfonctionnementFormHandlerStrategy
     */
    protected $dysfonctionnementFormHandlerStrategy;
    
    /**
     * @var AbstractDysfonctionnementFormHandlerStrategy
     */
    protected $newDysfonctionnementFormHandlerStrategy;
    
    /**
     * @var AbstractDysfonctionnementFormHandlerStrategy
     */
    protected $updateDysfonctionnementFormHandlerStrategy;
    
    public function setNewDysfonctionnementFormHandlerStrategy(AbstractDysfonctionnementFormHandlerStrategy $dysfonctionnementFormHandlerStrategy) {
        $this->newDysfonctionnementFormHandlerStrategy = $dysfonctionnementFormHandlerStrategy;
    }
    
    public function setUpdateDysfonctionnementFormHandlerStrategy(AbstractDysfonctionnementFormHandlerStrategy $dysfonctionnementFormHandlerStrategy) {
        $this->updateDysfonctionnementFormHandlerStrategy = $dysfonctionnementFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param Dysfonctionnement $dysfonctionnement
     * @return Dysfonctionnement
     */
    public function processForm(Dysfonctionnement $dysfonctionnement = null){
        if (is_null($dysfonctionnement)){ 
            $dysfonctionnement = new Dysfonctionnement();
            $this->dysfonctionnementFormHandlerStrategy = $this->newDysfonctionnementFormHandlerStrategy;
        } else {
            $this->dysfonctionnementFormHandlerStrategy = $this->updateDysfonctionnementFormHandlerStrategy;
        }
        return $dysfonctionnement;
    }
    
    public function handleForm(FormInterface $form, Dysfonctionnement $dysfonctionnement, Request $request)
    {
        if (
            (null === $dysfonctionnement->getId() && $request->isMethod('POST'))
            || (null !== $dysfonctionnement->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->dysfonctionnementFormHandlerStrategy->handleForm($request, $dysfonctionnement);
 
            return true;
        }
        return false;
    }
 
    public function createForm(Dysfonctionnement $dysfonctionnement)
    {
        return $this->dysfonctionnementFormHandlerStrategy->createForm($dysfonctionnement);
    }
 
    public function createView()
    {
        return $this->dysfonctionnementFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
