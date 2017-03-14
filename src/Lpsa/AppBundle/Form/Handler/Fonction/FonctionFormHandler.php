<?php

namespace Lpsa\AppBundle\Form\Handler\Fonction;

use Lpsa\AppBundle\Entity\Fonction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class FonctionFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractFonctionFormHandlerStrategy
     */
    protected $fonctionFormHandlerStrategy;
    
    /**
     * @var AbstractFonctionFormHandlerStrategy
     */
    protected $newFonctionFormHandlerStrategy;
    
    /**
     * @var AbstractFonctionFormHandlerStrategy
     */
    protected $updateFonctionFormHandlerStrategy;
    
    public function setNewFonctionFormHandlerStrategy(AbstractFonctionFormHandlerStrategy $fonctionFormHandlerStrategy) {
        $this->newFonctionFormHandlerStrategy = $fonctionFormHandlerStrategy;
    }
    
    public function setUpdateFonctionFormHandlerStrategy(AbstractFonctionFormHandlerStrategy $fonctionFormHandlerStrategy) {
        $this->updateFonctionFormHandlerStrategy = $fonctionFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param Fonction $fonction
     * @return Fonction
     */
    public function processForm(Fonction $fonction = null){
        if (is_null($fonction)){ 
            $fonction = new Fonction();
            $this->fonctionFormHandlerStrategy = $this->newFonctionFormHandlerStrategy;
        } else {
            $this->fonctionFormHandlerStrategy = $this->updateFonctionFormHandlerStrategy;
        }
        return $fonction;
    }
    
    public function handleForm(FormInterface $form, Fonction $fonction, Request $request)
    {
        if (
            (null === $fonction->getId() && $request->isMethod('POST'))
            || (null !== $fonction->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->fonctionFormHandlerStrategy->handleForm($request, $fonction);
 
            return true;
        }
        return false;
    }
 
    public function createForm(Fonction $fonction)
    {
        return $this->fonctionFormHandlerStrategy->createForm($fonction);
    }
 
    public function createView()
    {
        return $this->fonctionFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
