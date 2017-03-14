<?php

namespace Lpsa\AppBundle\Form\Handler\DepotCategorie;

use Lpsa\AppBundle\Entity\DepotCategorie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class DepotCategorieFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractDepotCategorieFormHandlerStrategy
     */
    protected $depotCategorieFormHandlerStrategy;
    
    /**
     * @var AbstractDepotCategorieFormHandlerStrategy
     */
    protected $newDepotCategorieFormHandlerStrategy;
    
    /**
     * @var AbstractDepotCategorieFormHandlerStrategy
     */
    protected $updateDepotCategorieFormHandlerStrategy;
    
    public function setNewDepotCategorieFormHandlerStrategy(AbstractDepotCategorieFormHandlerStrategy $depotCategorieFormHandlerStrategy) {
        $this->newDepotCategorieFormHandlerStrategy = $depotCategorieFormHandlerStrategy;
    }
    
    public function setUpdateDepotCategorieFormHandlerStrategy(AbstractDepotCategorieFormHandlerStrategy $depotCategorieFormHandlerStrategy) {
        $this->updateDepotCategorieFormHandlerStrategy = $depotCategorieFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param DepotCategorie $depotCategorie
     * @return DepotCategorie
     */
    public function processForm(DepotCategorie $depotCategorie = null){
        if (is_null($depotCategorie)){ 
            $depotCategorie = new DepotCategorie();
            $this->depotCategorieFormHandlerStrategy = $this->newDepotCategorieFormHandlerStrategy;
        } else {
            $this->depotCategorieFormHandlerStrategy = $this->updateDepotCategorieFormHandlerStrategy;
        }
        return $depotCategorie;
    }
    
    public function handleForm(FormInterface $form, DepotCategorie $depotCategorie, Request $request)
    {
        if (
            (null === $depotCategorie->getId() && $request->isMethod('POST'))
            || (null !== $depotCategorie->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->depotCategorieFormHandlerStrategy->handleForm($request, $depotCategorie);
 
            return true;
        }
        return false;
    }
 
    public function createForm(DepotCategorie $depotCategorie)
    {
        return $this->depotCategorieFormHandlerStrategy->createForm($depotCategorie);
    }
 
    public function createView()
    {
        return $this->depotCategorieFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
