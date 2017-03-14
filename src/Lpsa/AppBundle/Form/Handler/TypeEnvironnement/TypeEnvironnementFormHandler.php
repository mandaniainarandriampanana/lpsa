<?php

namespace Lpsa\AppBundle\Form\Handler\TypeEnvironnement;

use Lpsa\AppBundle\Entity\TypeEnvironnement;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class TypeEnvironnementFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractTypeEnvironnementFormHandlerStrategy
     */
    protected $typeenvironnementFormHandlerStrategy;
    
    /**
     * @var AbstractTypeEnvironnementFormHandlerStrategy
     */
    protected $newTypeEnvironnementFormHandlerStrategy;
    
    /**
     * @var AbstractTypeEnvironnementFormHandlerStrategy
     */
    protected $updateTypeEnvironnementFormHandlerStrategy;
    
    public function setNewTypeEnvironnementFormHandlerStrategy(AbstractTypeEnvironnementFormHandlerStrategy $typeenvironnementFormHandlerStrategy) {
        $this->newTypeEnvironnementFormHandlerStrategy = $typeenvironnementFormHandlerStrategy;
    }
    
    public function setUpdateTypeEnvironnementFormHandlerStrategy(AbstractTypeEnvironnementFormHandlerStrategy $typeenvironnementFormHandlerStrategy) {
        $this->updateTypeEnvironnementFormHandlerStrategy = $typeenvironnementFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param TypeEnvironnement $typeenvironnement
     * @return TypeEnvironnement
     */
    public function processForm(TypeEnvironnement $typeenvironnement = null){
        if (is_null($typeenvironnement)){ 
            $typeenvironnement = new TypeEnvironnement();
            $this->typeenvironnementFormHandlerStrategy = $this->newTypeEnvironnementFormHandlerStrategy;
        } else {
            $this->typeenvironnementFormHandlerStrategy = $this->updateTypeEnvironnementFormHandlerStrategy;
        }
        return $typeenvironnement;
    }
    
    public function handleForm(FormInterface $form, TypeEnvironnement $typeenvironnement, Request $request)
    {
        if (
            (null === $typeenvironnement->getId() && $request->isMethod('POST'))
            || (null !== $typeenvironnement->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->typeenvironnementFormHandlerStrategy->handleForm($request, $typeenvironnement);
 
            return true;
        }
        return false;
    }
 
    public function createForm(TypeEnvironnement $typeenvironnement)
    {
        return $this->typeenvironnementFormHandlerStrategy->createForm($typeenvironnement);
    }
 
    public function createView()
    {
        return $this->typeenvironnementFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
