<?php

namespace Lpsa\AppBundle\Form\Handler\Gravite;

use Lpsa\AppBundle\Entity\Gravite;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class GraviteFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractGraviteFormHandlerStrategy
     */
    protected $graviteFormHandlerStrategy;
    
    /**
     * @var AbstractGraviteFormHandlerStrategy
     */
    protected $newGraviteFormHandlerStrategy;
    
    /**
     * @var AbstractGraviteFormHandlerStrategy
     */
    protected $updateGraviteFormHandlerStrategy;
    
    public function setNewGraviteFormHandlerStrategy(AbstractGraviteFormHandlerStrategy $graviteFormHandlerStrategy) {
        $this->newGraviteFormHandlerStrategy = $graviteFormHandlerStrategy;
    }
    
    public function setUpdateGraviteFormHandlerStrategy(AbstractGraviteFormHandlerStrategy $graviteFormHandlerStrategy) {
        $this->updateGraviteFormHandlerStrategy = $graviteFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param Gravite $gravite
     * @return Gravite
     */
    public function processForm(Gravite $gravite = null){
        if (is_null($gravite)){ 
            $gravite = new Gravite();
            $this->graviteFormHandlerStrategy = $this->newGraviteFormHandlerStrategy;
        } else {
            $this->graviteFormHandlerStrategy = $this->updateGraviteFormHandlerStrategy;
        }
        return $gravite;
    }
    
    public function handleForm(FormInterface $form, Gravite $gravite, Request $request)
    {
        if (
            (null === $gravite->getId() && $request->isMethod('POST'))
            || (null !== $gravite->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->graviteFormHandlerStrategy->handleForm($request, $gravite);
 
            return true;
        }
        return false;
    }
 
    public function createForm(Gravite $gravite)
    {
        return $this->graviteFormHandlerStrategy->createForm($gravite);
    }
 
    public function createView()
    {
        return $this->graviteFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
