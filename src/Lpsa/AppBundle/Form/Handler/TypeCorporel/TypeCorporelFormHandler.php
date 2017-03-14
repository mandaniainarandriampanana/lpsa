<?php

namespace Lpsa\AppBundle\Form\Handler\TypeCorporel;

use Lpsa\AppBundle\Entity\TypeCorporel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class TypeCorporelFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractTypeCorporelFormHandlerStrategy
     */
    protected $typecorporelFormHandlerStrategy;
    
    /**
     * @var AbstractTypeCorporelFormHandlerStrategy
     */
    protected $newTypeCorporelFormHandlerStrategy;
    
    /**
     * @var AbstractTypeCorporelFormHandlerStrategy
     */
    protected $updateTypeCorporelFormHandlerStrategy;
    
    public function setNewTypeCorporelFormHandlerStrategy(AbstractTypeCorporelFormHandlerStrategy $typecorporelFormHandlerStrategy) {
        $this->newTypeCorporelFormHandlerStrategy = $typecorporelFormHandlerStrategy;
    }
    
    public function setUpdateTypeCorporelFormHandlerStrategy(AbstractTypeCorporelFormHandlerStrategy $typecorporelFormHandlerStrategy) {
        $this->updateTypeCorporelFormHandlerStrategy = $typecorporelFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param TypeCorporel $typecorporel
     * @return TypeCorporel
     */
    public function processForm(TypeCorporel $typecorporel = null){
        if (is_null($typecorporel)){ 
            $typecorporel = new TypeCorporel();
            $this->typecorporelFormHandlerStrategy = $this->newTypeCorporelFormHandlerStrategy;
        } else {
            $this->typecorporelFormHandlerStrategy = $this->updateTypeCorporelFormHandlerStrategy;
        }
        return $typecorporel;
    }
    
    public function handleForm(FormInterface $form, TypeCorporel $typecorporel, Request $request)
    {
        if (
            (null === $typecorporel->getId() && $request->isMethod('POST'))
            || (null !== $typecorporel->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->typecorporelFormHandlerStrategy->handleForm($request, $typecorporel);
 
            return true;
        }
        return false;
    }
 
    public function createForm(TypeCorporel $typecorporel)
    {
        return $this->typecorporelFormHandlerStrategy->createForm($typecorporel);
    }
 
    public function createView()
    {
        return $this->typecorporelFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
