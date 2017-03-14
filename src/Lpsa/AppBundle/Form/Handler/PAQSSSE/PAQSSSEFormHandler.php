<?php

namespace Lpsa\AppBundle\Form\Handler\PAQSSSE;

use Lpsa\AppBundle\Entity\PAQSSSE;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class PAQSSSEFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractPAQSSSEFormHandlerStrategy
     */
    protected $PAQSSSEFormHandlerStrategy;
    
    /**
     * @var AbstractPAQSSSEFormHandlerStrategy
     */
    protected $newPAQSSSEFormHandlerStrategy;
    
    /**
     * @var AbstractPAQSSSEFormHandlerStrategy
     */
    protected $updatePAQSSSEFormHandlerStrategy;
    
    public function setNewPAQSSSEFormHandlerStrategy(AbstractPAQSSSEFormHandlerStrategy $PAQSSSEFormHandlerStrategy) {
        $this->newPAQSSSEFormHandlerStrategy = $PAQSSSEFormHandlerStrategy;
    }
    
    public function setUpdatePAQSSSEFormHandlerStrategy(AbstractPAQSSSEFormHandlerStrategy $PAQSSSEFormHandlerStrategy) {
        $this->updatePAQSSSEFormHandlerStrategy = $PAQSSSEFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param PAQSSSE $PAQSSSE
     * @return PAQSSSE
     */
    public function processForm(PAQSSSE $PAQSSSE = null){
        if (is_null($PAQSSSE)){ 
            $PAQSSSE = new PAQSSSE();
            $this->PAQSSSEFormHandlerStrategy = $this->newPAQSSSEFormHandlerStrategy;
        } else {
            $this->PAQSSSEFormHandlerStrategy = $this->updatePAQSSSEFormHandlerStrategy;
        }
        return $PAQSSSE;
    }
    
    public function handleForm(FormInterface $form, PAQSSSE $PAQSSSE, Request $request)
    {
        if (
            (null === $PAQSSSE->getId() && $request->isMethod('POST'))
            || (null !== $PAQSSSE->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->PAQSSSEFormHandlerStrategy->handleForm($request, $PAQSSSE);
 
            return true;
        }
        return false;
    }
 
    public function createForm(PAQSSSE $PAQSSSE)
    {
        return $this->PAQSSSEFormHandlerStrategy->createForm($PAQSSSE);
    }
 
    public function createView()
    {
        return $this->PAQSSSEFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
