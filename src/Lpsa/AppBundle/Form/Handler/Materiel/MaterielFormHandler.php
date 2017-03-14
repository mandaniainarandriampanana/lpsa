<?php

namespace Lpsa\AppBundle\Form\Handler\Materiel;

use Lpsa\AppBundle\Entity\Materiel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class MaterielFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractMaterielFormHandlerStrategy
     */
    protected $materielFormHandlerStrategy;
    
    /**
     * @var AbstractMaterielFormHandlerStrategy
     */
    protected $newMaterielFormHandlerStrategy;
    
    /**
     * @var AbstractMaterielFormHandlerStrategy
     */
    protected $updateMaterielFormHandlerStrategy;
    
    public function setNewMaterielFormHandlerStrategy(AbstractMaterielFormHandlerStrategy $materielFormHandlerStrategy) {
        $this->newMaterielFormHandlerStrategy = $materielFormHandlerStrategy;
    }
    
    public function setUpdateMaterielFormHandlerStrategy(AbstractMaterielFormHandlerStrategy $materielFormHandlerStrategy) {
        $this->updateMaterielFormHandlerStrategy = $materielFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param Materiel $materiel
     * @return Materiel
     */
    public function processForm(Materiel $materiel = null){
        if (is_null($materiel)){ 
            $materiel = new Materiel();
            $this->materielFormHandlerStrategy = $this->newMaterielFormHandlerStrategy;
        } else {
            $this->materielFormHandlerStrategy = $this->updateMaterielFormHandlerStrategy;
        }
        return $materiel;
    }
    
    public function handleForm(FormInterface $form, Materiel $materiel, Request $request)
    {
        if (
            (null === $materiel->getId() && $request->isMethod('POST'))
            || (null !== $materiel->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->materielFormHandlerStrategy->handleForm($request, $materiel);
 
            return true;
        }
        return false;
    }
 
    public function createForm(Materiel $materiel)
    {
        return $this->materielFormHandlerStrategy->createForm($materiel);
    }
 
    public function createView()
    {
        return $this->materielFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
