<?php

namespace Lpsa\AppBundle\Form\Handler\EvenementCategorie;

use Lpsa\AppBundle\Entity\EvenementCategorie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class EvenementCategorieFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractEvenementCategorieFormHandlerStrategy
     */
    protected $evenementcategorieFormHandlerStrategy;
    
    /**
     * @var AbstractEvenementCategorieFormHandlerStrategy
     */
    protected $newEvenementCategorieFormHandlerStrategy;
    
    /**
     * @var AbstractEvenementCategorieFormHandlerStrategy
     */
    protected $updateEvenementCategorieFormHandlerStrategy;
    
    public function setNewEvenementCategorieFormHandlerStrategy(AbstractEvenementCategorieFormHandlerStrategy $evenementcategorieFormHandlerStrategy) {
        $this->newEvenementCategorieFormHandlerStrategy = $evenementcategorieFormHandlerStrategy;
    }
    
    public function setUpdateEvenementCategorieFormHandlerStrategy(AbstractEvenementCategorieFormHandlerStrategy $evenementcategorieFormHandlerStrategy) {
        $this->updateEvenementCategorieFormHandlerStrategy = $evenementcategorieFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param EvenementCategorie $evenementcategorie
     * @return EvenementCategorie
     */
    public function processForm(EvenementCategorie $evenementcategorie = null){
        if (is_null($evenementcategorie)){ 
            $evenementcategorie = new EvenementCategorie();
            $this->evenementcategorieFormHandlerStrategy = $this->newEvenementCategorieFormHandlerStrategy;
        } else {
            $this->evenementcategorieFormHandlerStrategy = $this->updateEvenementCategorieFormHandlerStrategy;
        }
        return $evenementcategorie;
    }
    
    public function handleForm(FormInterface $form, EvenementCategorie $evenementcategorie, Request $request)
    {
        if (
            (null === $evenementcategorie->getId() && $request->isMethod('POST'))
            || (null !== $evenementcategorie->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->evenementcategorieFormHandlerStrategy->handleForm($request, $evenementcategorie);
 
            return true;
        }
        return false;
    }
 
    public function createForm(EvenementCategorie $evenementcategorie)
    {
        return $this->evenementcategorieFormHandlerStrategy->createForm($evenementcategorie);
    }
 
    public function createView()
    {
        return $this->evenementcategorieFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
