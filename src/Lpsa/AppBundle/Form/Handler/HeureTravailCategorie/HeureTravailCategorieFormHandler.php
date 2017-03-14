<?php

namespace Lpsa\AppBundle\Form\Handler\HeureTravailCategorie;

use Lpsa\AppBundle\Entity\HeureTravailCategorie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class HeureTravailCategorieFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractHeureTravailCategorieFormHandlerStrategy
     */
    protected $heureTravailCategorieFormHandlerStrategy;
    
    /**
     * @var AbstractHeureTravailCategorieFormHandlerStrategy
     */
    protected $newHeureTravailCategorieFormHandlerStrategy;
    
    /**
     * @var AbstractHeureTravailCategorieFormHandlerStrategy
     */
    protected $updateHeureTravailCategorieFormHandlerStrategy;
    
    public function setNewHeureTravailCategorieFormHandlerStrategy(AbstractHeureTravailCategorieFormHandlerStrategy $heureTravailCategorieFormHandlerStrategy) {
        $this->newHeureTravailCategorieFormHandlerStrategy = $heureTravailCategorieFormHandlerStrategy;
    }
    
    public function setUpdateHeureTravailCategorieFormHandlerStrategy(AbstractHeureTravailCategorieFormHandlerStrategy $heureTravailCategorieFormHandlerStrategy) {
        $this->updateHeureTravailCategorieFormHandlerStrategy = $heureTravailCategorieFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param HeureTravailCategorie $heureTravailCategorie
     * @return HeureTravailCategorie
     */
    public function processForm(HeureTravailCategorie $heureTravailCategorie = null){
        if (is_null($heureTravailCategorie)){ 
            $heureTravailCategorie = new HeureTravailCategorie();
            $this->heureTravailCategorieFormHandlerStrategy = $this->newHeureTravailCategorieFormHandlerStrategy;
        } else {
            $this->heureTravailCategorieFormHandlerStrategy = $this->updateHeureTravailCategorieFormHandlerStrategy;
        }
        return $heureTravailCategorie;
    }
    
    public function handleForm(FormInterface $form, HeureTravailCategorie $heureTravailCategorie, Request $request)
    {
        if (
            (null === $heureTravailCategorie->getId() && $request->isMethod('POST'))
            || (null !== $heureTravailCategorie->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->heureTravailCategorieFormHandlerStrategy->handleForm($request, $heureTravailCategorie);
 
            return true;
        }
        return false;
    }
 
    public function createForm(HeureTravailCategorie $heureTravailCategorie)
    {
        return $this->heureTravailCategorieFormHandlerStrategy->createForm($heureTravailCategorie);
    }
 
    public function createView()
    {
        return $this->heureTravailCategorieFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
