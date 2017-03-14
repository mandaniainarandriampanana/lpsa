<?php

namespace Lpsa\AppBundle\Form\Handler\Departement;

use Lpsa\AppBundle\Entity\Departement;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class DepartementFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractDepartementFormHandlerStrategy
     */
    protected $departementFormHandlerStrategy;
    
    /**
     * @var AbstractDepartementFormHandlerStrategy
     */
    protected $newDepartementFormHandlerStrategy;
    
    /**
     * @var AbstractDepartementFormHandlerStrategy
     */
    protected $updateDepartementFormHandlerStrategy;
    
    public function setNewDepartementFormHandlerStrategy(AbstractDepartementFormHandlerStrategy $departementFormHandlerStrategy) {
        $this->newDepartementFormHandlerStrategy = $departementFormHandlerStrategy;
    }
    
    public function setUpdateDepartementFormHandlerStrategy(AbstractDepartementFormHandlerStrategy $departementFormHandlerStrategy) {
        $this->updateDepartementFormHandlerStrategy = $departementFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param Departement $departement
     * @return Departement
     */
    public function processForm(Departement $departement = null){
        if (is_null($departement)){ 
            $departement = new Departement();
            $this->departementFormHandlerStrategy = $this->newDepartementFormHandlerStrategy;
        } else {
            $this->departementFormHandlerStrategy = $this->updateDepartementFormHandlerStrategy;
        }
        return $departement;
    }
    
    public function handleForm(FormInterface $form, Departement $departement, Request $request)
    {
        if (
            (null === $departement->getId() && $request->isMethod('POST'))
            || (null !== $departement->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->departementFormHandlerStrategy->handleForm($request, $departement);
 
            return true;
        }
        return false;
    }
 
    public function createForm(Departement $departement)
    {
        return $this->departementFormHandlerStrategy->createForm($departement);
    }
 
    public function createView()
    {
        return $this->departementFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
