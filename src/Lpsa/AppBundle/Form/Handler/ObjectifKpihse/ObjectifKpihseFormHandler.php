<?php

namespace Lpsa\AppBundle\Form\Handler\ObjectifKpihse;

use Lpsa\AppBundle\Entity\ObjectifKpihse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class ObjectifKpihseFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractObjectifKpihseFormHandlerStrategy
     */
    protected $objectifKpihseFormHandlerStrategy;
    
    /**
     * @var AbstractObjectifKpihseFormHandlerStrategy
     */
    protected $newObjectifKpihseFormHandlerStrategy;
    
    /**
     * @var AbstractObjectifKpihseFormHandlerStrategy
     */
    protected $updateObjectifKpihseFormHandlerStrategy;
    
    public function setNewObjectifKpihseFormHandlerStrategy(AbstractObjectifKpihseFormHandlerStrategy $objectifKpihseFormHandlerStrategy) {
        $this->newObjectifKpihseFormHandlerStrategy = $objectifKpihseFormHandlerStrategy;
    }
    
    public function setUpdateObjectifKpihseFormHandlerStrategy(AbstractObjectifKpihseFormHandlerStrategy $objectifKpihseFormHandlerStrategy) {
        $this->updateObjectifKpihseFormHandlerStrategy = $objectifKpihseFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param ObjectifKpihse $objectifKpihse
     * @return ObjectifKpihse
     */
    public function processForm(ObjectifKpihse $objectifKpihse = null){
        if (is_null($objectifKpihse)){ 
            $objectifKpihse = new ObjectifKpihse();
            $this->objectifKpihseFormHandlerStrategy = $this->newObjectifKpihseFormHandlerStrategy;
        } else {
            $this->objectifKpihseFormHandlerStrategy = $this->updateObjectifKpihseFormHandlerStrategy;
        }
        return $objectifKpihse;
    }
    
    public function handleForm(FormInterface $form, ObjectifKpihse $objectifKpihse, Request $request)
    {
        if (
            (null === $objectifKpihse->getId() && $request->isMethod('POST'))
            || (null !== $objectifKpihse->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->objectifKpihseFormHandlerStrategy->handleForm($request, $objectifKpihse);
 
            return true;
        }
        return false;
    }
 
    public function createForm(ObjectifKpihse $objectifKpihse)
    {
        return $this->objectifKpihseFormHandlerStrategy->createForm($objectifKpihse);
    }
 
    public function createView()
    {
        return $this->objectifKpihseFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
