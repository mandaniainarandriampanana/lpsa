<?php

namespace Lpsa\AppBundle\Form\Handler\TypeMateriel;

use Lpsa\AppBundle\Entity\TypeMateriel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class TypeMaterielFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractTypeMaterielFormHandlerStrategy
     */
    protected $typematerielFormHandlerStrategy;
    
    /**
     * @var AbstractTypeMaterielFormHandlerStrategy
     */
    protected $newTypeMaterielFormHandlerStrategy;
    
    /**
     * @var AbstractTypeMaterielFormHandlerStrategy
     */
    protected $updateTypeMaterielFormHandlerStrategy;
    
    public function setNewTypeMaterielFormHandlerStrategy(AbstractTypeMaterielFormHandlerStrategy $typematerielFormHandlerStrategy) {
        $this->newTypeMaterielFormHandlerStrategy = $typematerielFormHandlerStrategy;
    }
    
    public function setUpdateTypeMaterielFormHandlerStrategy(AbstractTypeMaterielFormHandlerStrategy $typematerielFormHandlerStrategy) {
        $this->updateTypeMaterielFormHandlerStrategy = $typematerielFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param TypeMateriel $typemateriel
     * @return TypeMateriel
     */
    public function processForm(TypeMateriel $typemateriel = null){
        if (is_null($typemateriel)){ 
            $typemateriel = new TypeMateriel();
            $this->typematerielFormHandlerStrategy = $this->newTypeMaterielFormHandlerStrategy;
        } else {
            $this->typematerielFormHandlerStrategy = $this->updateTypeMaterielFormHandlerStrategy;
        }
        return $typemateriel;
    }
    
    public function handleForm(FormInterface $form, TypeMateriel $typemateriel, Request $request)
    {
        if (
            (null === $typemateriel->getId() && $request->isMethod('POST'))
            || (null !== $typemateriel->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->typematerielFormHandlerStrategy->handleForm($request, $typemateriel);
 
            return true;
        }
        return false;
    }
 
    public function createForm(TypeMateriel $typemateriel)
    {
        return $this->typematerielFormHandlerStrategy->createForm($typemateriel);
    }
 
    public function createView()
    {
        return $this->typematerielFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
