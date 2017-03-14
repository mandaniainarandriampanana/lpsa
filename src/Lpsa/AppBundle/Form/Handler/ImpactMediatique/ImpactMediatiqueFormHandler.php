<?php

namespace Lpsa\AppBundle\Form\Handler\ImpactMediatique;

use Lpsa\AppBundle\Entity\ImpactMediatique;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class ImpactMediatiqueFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractImpactMediatiqueFormHandlerStrategy
     */
    protected $impactmediatiqueFormHandlerStrategy;
    
    /**
     * @var AbstractImpactMediatiqueFormHandlerStrategy
     */
    protected $newImpactMediatiqueFormHandlerStrategy;
    
    /**
     * @var AbstractImpactMediatiqueFormHandlerStrategy
     */
    protected $updateImpactMediatiqueFormHandlerStrategy;
    
    public function setNewImpactMediatiqueFormHandlerStrategy(AbstractImpactMediatiqueFormHandlerStrategy $impactmediatiqueFormHandlerStrategy) {
        $this->newImpactMediatiqueFormHandlerStrategy = $impactmediatiqueFormHandlerStrategy;
    }
    
    public function setUpdateImpactMediatiqueFormHandlerStrategy(AbstractImpactMediatiqueFormHandlerStrategy $impactmediatiqueFormHandlerStrategy) {
        $this->updateImpactMediatiqueFormHandlerStrategy = $impactmediatiqueFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param ImpactMediatique $impactmediatique
     * @return ImpactMediatique
     */
    public function processForm(ImpactMediatique $impactmediatique = null){
        if (is_null($impactmediatique)){ 
            $impactmediatique = new ImpactMediatique();
            $this->impactmediatiqueFormHandlerStrategy = $this->newImpactMediatiqueFormHandlerStrategy;
        } else {
            $this->impactmediatiqueFormHandlerStrategy = $this->updateImpactMediatiqueFormHandlerStrategy;
        }
        return $impactmediatique;
    }
    
    public function handleForm(FormInterface $form, ImpactMediatique $impactmediatique, Request $request)
    {
        if (
            (null === $impactmediatique->getId() && $request->isMethod('POST'))
            || (null !== $impactmediatique->getId() && $request->isMethod('PUT'))
        ) { 
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
 
            $this->message = $this->impactmediatiqueFormHandlerStrategy->handleForm($request, $impactmediatique);
 
            return true;
        }
        return false;
    }
 
    public function createForm(ImpactMediatique $impactmediatique)
    {
        return $this->impactmediatiqueFormHandlerStrategy->createForm($impactmediatique);
    }
 
    public function createView()
    {
        return $this->impactmediatiqueFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}
