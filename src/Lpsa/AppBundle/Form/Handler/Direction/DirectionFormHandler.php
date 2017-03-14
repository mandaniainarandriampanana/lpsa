<?php

namespace Lpsa\AppBundle\Form\Handler\Direction;

use Lpsa\AppBundle\Entity\Direction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class DirectionFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractDirectionFormHandlerStrategy
     */
    protected $directionFormHandlerStrategy;
    
    /**
     * @var AbstractDirectionFormHandlerStrategy
     */
    protected $newDirectionFormHandlerStrategy;
    
    /**
     * @var AbstractDirectionFormHandlerStrategy
     */
    protected $updateDirectionFormHandlerStrategy;
    
    public function setNewDirectionFormHandlerStrategy(AbstractDirectionFormHandlerStrategy $directionFormHandlerStrategy) {
        $this->newDirectionFormHandlerStrategy = $directionFormHandlerStrategy;
    }
    
    public function setUpdateDirectionFormHandlerStrategy(AbstractDirectionFormHandlerStrategy $directionFormHandlerStrategy) {
        $this->updateDirectionFormHandlerStrategy = $directionFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param Direction $direction
     * @return Direction
     */
    public function processForm(Direction $direction = null){
        if (is_null($direction)){ 
            $direction = new Direction();
            $this->directionFormHandlerStrategy = $this->newDirectionFormHandlerStrategy;
        } else {
            $this->directionFormHandlerStrategy = $this->updateDirectionFormHandlerStrategy;
        }
        return $direction;
    }
    
    public function handleForm(FormInterface $form, Direction $direction, Request $request)
    {
        if (
            (null === $direction->getId() && $request->isMethod('POST'))
            || (null !== $direction->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->directionFormHandlerStrategy->handleForm($request, $direction);
 
            return true;
        }
        return false;
    }
 
    public function createForm(Direction $direction)
    {
        return $this->directionFormHandlerStrategy->createForm($direction);
    }
 
    public function createView()
    {
        return $this->directionFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
