<?php

namespace Lpsa\AppBundle\Form\Handler\Laboratoire;

use Lpsa\AppBundle\Entity\Laboratoire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class LaboratoireFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractLaboratoireFormHandlerStrategy
     */
    protected $laboratoireFormHandlerStrategy;
    
    /**
     * @var AbstractLaboratoireFormHandlerStrategy
     */
    protected $newLaboratoireFormHandlerStrategy;
    
    /**
     * @var AbstractLaboratoireFormHandlerStrategy
     */
    protected $updateLaboratoireFormHandlerStrategy;
    
    public function setNewLaboratoireFormHandlerStrategy(AbstractLaboratoireFormHandlerStrategy $laboratoireFormHandlerStrategy) {
        $this->newLaboratoireFormHandlerStrategy = $laboratoireFormHandlerStrategy;
    }
    
    public function setUpdateLaboratoireFormHandlerStrategy(AbstractLaboratoireFormHandlerStrategy $laboratoireFormHandlerStrategy) {
        $this->updateLaboratoireFormHandlerStrategy = $laboratoireFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param Laboratoire $Laboratoire
     * @return Laboratoire
     */
    public function processForm(Laboratoire $laboratoire = null){
        if (is_null($laboratoire)){ 
            $laboratoire = new Laboratoire();
            $this->laboratoireFormHandlerStrategy = $this->newLaboratoireFormHandlerStrategy;
        } else {
            $this->laboratoireFormHandlerStrategy = $this->updateLaboratoireFormHandlerStrategy;
        }
        return $laboratoire;
    }
    
    public function handleForm(FormInterface $form, Laboratoire $laboratoire, Request $request)
    {
        if (
            (null === $laboratoire->getId() && $request->isMethod('POST'))
            || (null !== $laboratoire->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->laboratoireFormHandlerStrategy->handleForm($request, $laboratoire);
 
            return true;
        }
        return false;
    }
 
    public function createForm(Laboratoire $laboratoire)
    {
        return $this->laboratoireFormHandlerStrategy->createForm($laboratoire);
    }
 
    public function createView()
    {
        return $this->laboratoireFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
