<?php

namespace Lpsa\AppBundle\Form\Handler\ExerciceUrgence;

use Lpsa\AppBundle\Entity\ExerciceUrgence;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class ExerciceUrgenceFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractExerciceUrgenceFormHandlerStrategy
     */
    protected $exerciceUrgenceFormHandlerStrategy;
    
    /**
     * @var AbstractExerciceUrgenceFormHandlerStrategy
     */
    protected $newExerciceUrgenceFormHandlerStrategy;
    
    /**
     * @var AbstractExerciceUrgenceFormHandlerStrategy
     */
    protected $updateExerciceUrgenceFormHandlerStrategy;
    
    public function setNewExerciceUrgenceFormHandlerStrategy(AbstractExerciceUrgenceFormHandlerStrategy $exerciceUrgenceFormHandlerStrategy) {
        $this->newExerciceUrgenceFormHandlerStrategy = $exerciceUrgenceFormHandlerStrategy;
    }
    
    public function setUpdateExerciceUrgenceFormHandlerStrategy(AbstractExerciceUrgenceFormHandlerStrategy $exerciceUrgenceFormHandlerStrategy) {
        $this->updateExerciceUrgenceFormHandlerStrategy = $exerciceUrgenceFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param ExerciceUrgence $exerciceUrgence
     * @return ExerciceUrgence
     */
    public function processForm(ExerciceUrgence $exerciceUrgence = null){
        if (is_null($exerciceUrgence)){ 
            $exerciceUrgence = new ExerciceUrgence();
            $this->exerciceUrgenceFormHandlerStrategy = $this->newExerciceUrgenceFormHandlerStrategy;
        } else {
            $this->exerciceUrgenceFormHandlerStrategy = $this->updateExerciceUrgenceFormHandlerStrategy;
        }
        return $exerciceUrgence;
    }
    
    public function handleForm(FormInterface $form, ExerciceUrgence $exerciceUrgence, Request $request)
    {
        if (
            (null === $exerciceUrgence->getId() && $request->isMethod('POST'))
            || (null !== $exerciceUrgence->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->exerciceUrgenceFormHandlerStrategy->handleForm($request, $exerciceUrgence);
 
            return true;
        }
        return false;
    }
 
    public function createForm(ExerciceUrgence $exerciceUrgence)
    {
        return $this->exerciceUrgenceFormHandlerStrategy->createForm($exerciceUrgence);
    }
 
    public function createView()
    {
        return $this->exerciceUrgenceFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
