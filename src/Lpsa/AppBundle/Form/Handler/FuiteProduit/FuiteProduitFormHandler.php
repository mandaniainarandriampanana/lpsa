<?php

namespace Lpsa\AppBundle\Form\Handler\FuiteProduit;

use Lpsa\AppBundle\Entity\FuiteProduit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class FuiteProduitFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractFuiteProduitFormHandlerStrategy
     */
    protected $fuiteProduitFormHandlerStrategy;
    
    /**
     * @var AbstractFuiteProduitFormHandlerStrategy
     */
    protected $newFuiteProduitFormHandlerStrategy;
    
    /**
     * @var AbstractFuiteProduitFormHandlerStrategy
     */
    protected $updateFuiteProduitFormHandlerStrategy;
    
    public function setNewFuiteProduitFormHandlerStrategy(AbstractFuiteProduitFormHandlerStrategy $fuiteProduitFormHandlerStrategy) {
        $this->newFuiteProduitFormHandlerStrategy = $fuiteProduitFormHandlerStrategy;
    }
    
    public function setUpdateFuiteProduitFormHandlerStrategy(AbstractFuiteProduitFormHandlerStrategy $fuiteProduitFormHandlerStrategy) {
        $this->updateFuiteProduitFormHandlerStrategy = $fuiteProduitFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param FuiteProduit $fuiteProduit
     * @return FuiteProduit
     */
    public function processForm(FuiteProduit $fuiteProduit = null){
        if (is_null($fuiteProduit)){ 
            $fuiteProduit = new FuiteProduit();
            $this->fuiteProduitFormHandlerStrategy = $this->newFuiteProduitFormHandlerStrategy;
        } else {
            $this->fuiteProduitFormHandlerStrategy = $this->updateFuiteProduitFormHandlerStrategy;
        }
        return $fuiteProduit;
    }
    
    public function handleForm(FormInterface $form, FuiteProduit $fuiteProduit, Request $request)
    {
        if (
            (null === $fuiteProduit->getId() && $request->isMethod('POST'))
            || (null !== $fuiteProduit->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->fuiteProduitFormHandlerStrategy->handleForm($request, $fuiteProduit);
 
            return true;
        }
        return false;
    }
 
    public function createForm(FuiteProduit $fuiteProduit)
    {
        return $this->fuiteProduitFormHandlerStrategy->createForm($fuiteProduit);
    }
 
    public function createView()
    {
        return $this->fuiteProduitFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
