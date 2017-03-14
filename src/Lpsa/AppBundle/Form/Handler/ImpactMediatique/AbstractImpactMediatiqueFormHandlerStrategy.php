<?php

namespace Lpsa\AppBundle\Form\Handler\ImpactMediatique;

use Lpsa\AppBundle\Entity\ImpactMediatique;
use Lpsa\AppBundle\Entity\Manager\Interfaces\ImpactMediatiqueManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractImpactMediatiqueFormHandlerStrategy implements ImpactMediatiqueFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var ImpactMediatiqueManagerInterface
     */
    protected $impactmediatiqueManager;
 
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;
 
    /**
     * @var RouterInterface $router
     */
    protected $router;
 
    /**
     * @var TranslatorInterface
     */
    protected $translator;
 
        /**
     * @param ImpactMediatiqueManagerInterface $impactmediatiqueManager
     * @return AbstractImpactMediatiqueFormHandlerStrategy
     */
    public function setImpactMediatiqueManager($impactmediatiqueManager)
    {
        $this->impactmediatiqueManager = $impactmediatiqueManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractImpactMediatiqueFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractImpactMediatiqueFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractImpactMediatiqueFormHandlerStrategy
     */
    public function setTranslator($translator)
    {
        $this->translator = $translator;
        return $this;
    }
    
    public function createView()
    {
        return $this->form->createView();
    }
 
    abstract public function handleForm(Request $request, ImpactMediatique $impactmediatique);
 
    abstract public function createForm(ImpactMediatique $impactmediatique);
}
