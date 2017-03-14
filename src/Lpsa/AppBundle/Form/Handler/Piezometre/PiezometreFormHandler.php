<?php

namespace Lpsa\AppBundle\Form\Handler\Piezometre;

use Lpsa\AppBundle\Entity\Piezometre;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class PiezometreFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractPiezometreFormHandlerStrategy
     */
    protected $piezometreFormHandlerStrategy;
    
    /**
     * @var AbstractPiezometreFormHandlerStrategy
     */
    protected $newPiezometreFormHandlerStrategy;
    
    /**
     * @var AbstractPiezometreFormHandlerStrategy
     */
    protected $updatePiezometreFormHandlerStrategy;
    
    public function setNewPiezometreFormHandlerStrategy(AbstractPiezometreFormHandlerStrategy $piezometreFormHandlerStrategy) {
        $this->newPiezometreFormHandlerStrategy = $piezometreFormHandlerStrategy;
    }
    
    public function setUpdatePiezometreFormHandlerStrategy(AbstractPiezometreFormHandlerStrategy $piezometreFormHandlerStrategy) {
        $this->updatePiezometreFormHandlerStrategy = $piezometreFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param Piezometre $piezometre
     * @return Piezometre
     */
    public function processForm(Piezometre $piezometre = null){
        if (is_null($piezometre)){ 
            $piezometre = new Piezometre();
            $this->PiezometreFormHandlerStrategy = $this->newPiezometreFormHandlerStrategy;
        } else {
            $this->PiezometreFormHandlerStrategy = $this->updatePiezometreFormHandlerStrategy;
        }
        return $piezometre;
    }
    
    public function handleForm(FormInterface $form, Piezometre $piezometre, Request $request)
    {
        if (
            (null === $piezometre->getId() && $request->isMethod('POST'))
            || (null !== $piezometre->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->PiezometreFormHandlerStrategy->handleForm($request, $piezometre);
 
            return true;
        }
        return false;
    }
 
    public function createForm(Piezometre $piezometre)
    {
        return $this->PiezometreFormHandlerStrategy->createForm($piezometre);
    }
 
    public function createView()
    {
        return $this->PiezometreFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
