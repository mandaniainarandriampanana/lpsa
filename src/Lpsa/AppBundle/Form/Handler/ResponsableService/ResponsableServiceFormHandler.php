<?php

namespace Lpsa\AppBundle\Form\Handler\ResponsableService;

use Lpsa\AppBundle\Entity\ResponsableService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class ResponsableServiceFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractResponsableServiceFormHandlerStrategy
     */
    protected $responsableServiceFormHandlerStrategy;
    
    /**
     * @var AbstractResponsableServiceFormHandlerStrategy
     */
    protected $newResponsableServiceFormHandlerStrategy;
    
    /**
     * @var AbstractResponsableServiceFormHandlerStrategy
     */
    protected $updateResponsableServiceFormHandlerStrategy;
    
    public function setNewResponsableServiceFormHandlerStrategy(AbstractResponsableServiceFormHandlerStrategy $responsableServiceFormHandlerStrategy) {
        $this->newResponsableServiceFormHandlerStrategy = $responsableServiceFormHandlerStrategy;
    }
    
    public function setUpdateResponsableServiceFormHandlerStrategy(AbstractResponsableServiceFormHandlerStrategy $responsableServiceFormHandlerStrategy) {
        $this->updateResponsableServiceFormHandlerStrategy = $responsableServiceFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param ResponsableService $responsableService
     * @return ResponsableService
     */
    public function processForm(ResponsableService $responsableService = null){
        if (is_null($responsableService)){ 
            $responsableService = new ResponsableService();
            $this->responsableServiceFormHandlerStrategy = $this->newResponsableServiceFormHandlerStrategy;
        } else {
            $this->responsableServiceFormHandlerStrategy = $this->updateResponsableServiceFormHandlerStrategy;
        }
        return $responsableService;
    }
    
    public function handleForm(FormInterface $form, ResponsableService $responsableService, Request $request)
    {
        if (
            (null === $responsableService->getId() && $request->isMethod('POST'))
            || (null !== $responsableService->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->responsableServiceFormHandlerStrategy->handleForm($request, $responsableService);
 
            return true;
        }
        return false;
    }
 
    public function createForm(ResponsableService $responsableService)
    {
        return $this->responsableServiceFormHandlerStrategy->createForm($responsableService);
    }
 
    public function createView()
    {
        return $this->responsableServiceFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
