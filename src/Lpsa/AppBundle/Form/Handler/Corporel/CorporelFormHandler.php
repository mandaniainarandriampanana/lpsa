<?php

namespace Lpsa\AppBundle\Form\Handler\Corporel;

use Lpsa\AppBundle\Entity\Corporel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class CorporelFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractCorporelFormHandlerStrategy
     */
    protected $corporelFormHandlerStrategy;
    
    /**
     * @var AbstractCorporelFormHandlerStrategy
     */
    protected $newCorporelFormHandlerStrategy;
    
    /**
     * @var AbstractCorporelFormHandlerStrategy
     */
    protected $updateCorporelFormHandlerStrategy;
    
    public function setNewCorporelFormHandlerStrategy(AbstractCorporelFormHandlerStrategy $corporelFormHandlerStrategy) {
        $this->newCorporelFormHandlerStrategy = $corporelFormHandlerStrategy;
    }
    
    public function setUpdateCorporelFormHandlerStrategy(AbstractCorporelFormHandlerStrategy $corporelFormHandlerStrategy) {
        $this->updateCorporelFormHandlerStrategy = $corporelFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param Corporel $corporel
     * @return Corporel
     */
    public function processForm(Corporel $corporel = null){
        if (is_null($corporel)){ 
            $corporel = new Corporel();
            $this->corporelFormHandlerStrategy = $this->newCorporelFormHandlerStrategy;
        } else {
            $this->corporelFormHandlerStrategy = $this->updateCorporelFormHandlerStrategy;
        }
        return $corporel;
    }
    
    public function handleForm(FormInterface $form, Corporel $corporel, Request $request)
    {
        if (
            (null === $corporel->getId() && $request->isMethod('POST'))
            || (null !== $corporel->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->corporelFormHandlerStrategy->handleForm($request, $corporel);
 
            return true;
        }
        return false;
    }
 
    public function createForm(Corporel $corporel)
    {
        return $this->corporelFormHandlerStrategy->createForm($corporel);
    }
 
    public function createView()
    {
        return $this->corporelFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
