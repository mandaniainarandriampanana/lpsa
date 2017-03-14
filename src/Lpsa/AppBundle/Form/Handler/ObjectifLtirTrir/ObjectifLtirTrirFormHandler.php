<?php

namespace Lpsa\AppBundle\Form\Handler\ObjectifLtirTrir;

use Lpsa\AppBundle\Entity\ObjectifLtirTrir;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class ObjectifLtirTrirFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractObjectifLtirTrirFormHandlerStrategy
     */
    protected $objectifLtirTrirFormHandlerStrategy;
    
    /**
     * @var AbstractObjectifLtirTrirFormHandlerStrategy
     */
    protected $newObjectifLtirTrirFormHandlerStrategy;
    
    /**
     * @var AbstractObjectifLtirTrirFormHandlerStrategy
     */
    protected $updateObjectifLtirTrirFormHandlerStrategy;
    
    public function setNewObjectifLtirTrirFormHandlerStrategy(AbstractObjectifLtirTrirFormHandlerStrategy $objectifLtirTrirFormHandlerStrategy) {
        $this->newObjectifLtirTrirFormHandlerStrategy = $objectifLtirTrirFormHandlerStrategy;
    }
    
    public function setUpdateObjectifLtirTrirFormHandlerStrategy(AbstractObjectifLtirTrirFormHandlerStrategy $objectifLtirTrirFormHandlerStrategy) {
        $this->updateObjectifLtirTrirFormHandlerStrategy = $objectifLtirTrirFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param ObjectifLtirTrir $objectifLtirTrir
     * @return ObjectifLtirTrir
     */
    public function processForm(ObjectifLtirTrir $objectifLtirTrir = null){
        if (is_null($objectifLtirTrir)){ 
            $objectifLtirTrir = new ObjectifLtirTrir();
            $this->objectifLtirTrirFormHandlerStrategy = $this->newObjectifLtirTrirFormHandlerStrategy;
        } else {
            $this->objectifLtirTrirFormHandlerStrategy = $this->updateObjectifLtirTrirFormHandlerStrategy;
        }
        return $objectifLtirTrir;
    }
    
    public function handleForm(FormInterface $form, ObjectifLtirTrir $objectifLtirTrir, Request $request)
    {
        if (
            (null === $objectifLtirTrir->getId() && $request->isMethod('POST'))
            || (null !== $objectifLtirTrir->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->objectifLtirTrirFormHandlerStrategy->handleForm($request, $objectifLtirTrir);
 
            return true;
        }
        return false;
    }
 
    public function createForm(ObjectifLtirTrir $objectifLtirTrir)
    {
        return $this->objectifLtirTrirFormHandlerStrategy->createForm($objectifLtirTrir);
    }
 
    public function createView()
    {
        return $this->objectifLtirTrirFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
