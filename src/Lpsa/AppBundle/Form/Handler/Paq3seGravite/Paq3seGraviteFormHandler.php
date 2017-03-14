<?php

namespace Lpsa\AppBundle\Form\Handler\Paq3seGravite;

use Lpsa\AppBundle\Entity\Paq3seGravite;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class Paq3seGraviteFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractPaq3seGraviteFormHandlerStrategy
     */
    protected $paq3seGraviteFormHandlerStrategy;
    
    /**
     * @var AbstractPaq3seGraviteFormHandlerStrategy
     */
    protected $newPaq3seGraviteFormHandlerStrategy;
    
    /**
     * @var AbstractPaq3seGraviteFormHandlerStrategy
     */
    protected $updatePaq3seGraviteFormHandlerStrategy;
    
    public function setNewPaq3seGraviteFormHandlerStrategy(AbstractPaq3seGraviteFormHandlerStrategy $paq3seGraviteFormHandlerStrategy) {
        $this->newPaq3seGraviteFormHandlerStrategy = $paq3seGraviteFormHandlerStrategy;
    }
    
    public function setUpdatePaq3seGraviteFormHandlerStrategy(AbstractPaq3seGraviteFormHandlerStrategy $paq3seGraviteFormHandlerStrategy) {
        $this->updatePaq3seGraviteFormHandlerStrategy = $paq3seGraviteFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param Paq3seGravite $paq3seGravite
     * @return Paq3seGravite
     */
    public function processForm(Paq3seGravite $paq3seGravite = null){
        if (is_null($paq3seGravite)){ 
            $paq3seGravite = new Paq3seGravite();
            $this->paq3seGraviteFormHandlerStrategy = $this->newPaq3seGraviteFormHandlerStrategy;
        } else {
            $this->paq3seGraviteFormHandlerStrategy = $this->updatePaq3seGraviteFormHandlerStrategy;
        }
        return $paq3seGravite;
    }
    
    public function handleForm(FormInterface $form, Paq3seGravite $paq3seGravite, Request $request)
    {
        if (
            (null === $paq3seGravite->getId() && $request->isMethod('POST'))
            || (null !== $paq3seGravite->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->paq3seGraviteFormHandlerStrategy->handleForm($request, $paq3seGravite);
 
            return true;
        }
        return false;
    }
 
    public function createForm(Paq3seGravite $paq3seGravite)
    {
        return $this->paq3seGraviteFormHandlerStrategy->createForm($paq3seGravite);
    }
 
    public function createView()
    {
        return $this->paq3seGraviteFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
