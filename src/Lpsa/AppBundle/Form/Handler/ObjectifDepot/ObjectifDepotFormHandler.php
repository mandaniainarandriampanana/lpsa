<?php

namespace Lpsa\AppBundle\Form\Handler\ObjectifDepot;

use Lpsa\AppBundle\Entity\ObjectifDepot;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class ObjectifDepotFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractObjectifDepotFormHandlerStrategy
     */
    protected $objectifdepotFormHandlerStrategy;
    
    /**
     * @var AbstractObjectifDepotFormHandlerStrategy
     */
    protected $newObjectifDepotFormHandlerStrategy;
    
    /**
     * @var AbstractObjectifDepotFormHandlerStrategy
     */
    protected $updateObjectifDepotFormHandlerStrategy;
    
    public function setNewObjectifDepotFormHandlerStrategy(AbstractObjectifDepotFormHandlerStrategy $objectifdepotFormHandlerStrategy) {
        $this->newObjectifDepotFormHandlerStrategy = $objectifdepotFormHandlerStrategy;
    }
    
    public function setUpdateObjectifDepotFormHandlerStrategy(AbstractObjectifDepotFormHandlerStrategy $objectifdepotFormHandlerStrategy) {
        $this->updateObjectifDepotFormHandlerStrategy = $objectifdepotFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param ObjectifDepot $objectifdepot
     * @return ObjectifDepot
     */
    public function processForm(ObjectifDepot $objectifdepot = null){
        if (is_null($objectifdepot)){ 
            $objectifdepot = new ObjectifDepot();
            $this->objectifdepotFormHandlerStrategy = $this->newObjectifDepotFormHandlerStrategy;
        } else {
            $this->objectifdepotFormHandlerStrategy = $this->updateObjectifDepotFormHandlerStrategy;
        }
        return $objectifdepot;
    }
    
    public function handleForm(FormInterface $form, ObjectifDepot $objectifdepot, Request $request)
    {
        if (
            (null === $objectifdepot->getId() && $request->isMethod('POST'))
            || (null !== $objectifdepot->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->objectifdepotFormHandlerStrategy->handleForm($request, $objectifdepot);
 
            return true;
        }
        return false;
    }
 
    public function createForm(ObjectifDepot $objectifdepot)
    {
        return $this->objectifdepotFormHandlerStrategy->createForm($objectifdepot);
    }
 
    public function createView()
    {
        return $this->objectifdepotFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
