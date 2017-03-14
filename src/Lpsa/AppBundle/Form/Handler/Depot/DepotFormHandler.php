<?php

namespace Lpsa\AppBundle\Form\Handler\Depot;

use Lpsa\AppBundle\Entity\Depot;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class DepotFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractDepotFormHandlerStrategy
     */
    protected $depotFormHandlerStrategy;
    
    /**
     * @var AbstractDepotFormHandlerStrategy
     */
    protected $newDepotFormHandlerStrategy;
    
    /**
     * @var AbstractDepotFormHandlerStrategy
     */
    protected $updateDepotFormHandlerStrategy;
    
    public function setNewDepotFormHandlerStrategy(AbstractDepotFormHandlerStrategy $depotFormHandlerStrategy) {
        $this->newDepotFormHandlerStrategy = $depotFormHandlerStrategy;
    }
    
    public function setUpdateDepotFormHandlerStrategy(AbstractDepotFormHandlerStrategy $depotFormHandlerStrategy) {
        $this->updateDepotFormHandlerStrategy = $depotFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param Depot $depot
     * @return Depot
     */
    public function processForm(Depot $depot = null){
        if (is_null($depot)){ 
            $depot = new Depot();
            $this->depotFormHandlerStrategy = $this->newDepotFormHandlerStrategy;
        } else {
            $this->depotFormHandlerStrategy = $this->updateDepotFormHandlerStrategy;
        }
        return $depot;
    }
    
    public function handleForm(FormInterface $form, Depot $depot, Request $request)
    {
        if (
            (null === $depot->getId() && $request->isMethod('POST'))
            || (null !== $depot->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->depotFormHandlerStrategy->handleForm($request, $depot);
 
            return true;
        }
        return false;
    }
 
    public function createForm(Depot $depot)
    {
        return $this->depotFormHandlerStrategy->createForm($depot);
    }
 
    public function createView()
    {
        return $this->depotFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
