<?php

namespace Lpsa\AppBundle\Form\Handler\Decanteur;

use Lpsa\AppBundle\Entity\Decanteur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class DecanteurFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractDecanteurFormHandlerStrategy
     */
    protected $DecanteurFormHandlerStrategy;
    
    /**
     * @var AbstractDecanteurFormHandlerStrategy
     */
    protected $newDecanteurFormHandlerStrategy;
    
    /**
     * @var AbstractDecanteurFormHandlerStrategy
     */
    protected $updateDecanteurFormHandlerStrategy;
    
    public function setNewDecanteurFormHandlerStrategy(AbstractDecanteurFormHandlerStrategy $DecanteurFormHandlerStrategy) {
        $this->newDecanteurFormHandlerStrategy = $DecanteurFormHandlerStrategy;
    }
    
    public function setUpdateDecanteurFormHandlerStrategy(AbstractDecanteurFormHandlerStrategy $DecanteurFormHandlerStrategy) {
        $this->updateDecanteurFormHandlerStrategy = $DecanteurFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param Decanteur $decanteur
     * @return Decanteur
     */
    public function processForm(Decanteur $decanteur = null){
        if (is_null($decanteur)){ 
            $decanteur = new Decanteur();
            $this->DecanteurFormHandlerStrategy = $this->newDecanteurFormHandlerStrategy;
        } else {
            $this->DecanteurFormHandlerStrategy = $this->updateDecanteurFormHandlerStrategy;
        }
        return $decanteur;
    }
    
    public function handleForm(FormInterface $form, Decanteur $decanteur, Request $request)
    {
        if (
            (null === $decanteur->getId() && $request->isMethod('POST'))
            || (null !== $decanteur->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->DecanteurFormHandlerStrategy->handleForm($request, $decanteur);
 
            return true;
        }
        return false;
    }
 
    public function createForm(Decanteur $decanteur)
    {
        return $this->DecanteurFormHandlerStrategy->createForm($decanteur);
    }
 
    public function createView()
    {
        return $this->DecanteurFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
