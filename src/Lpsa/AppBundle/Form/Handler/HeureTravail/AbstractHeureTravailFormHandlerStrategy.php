<?php

namespace Lpsa\AppBundle\Form\Handler\HeureTravail;

use Lpsa\AppBundle\Entity\HeureTravail;
use Lpsa\AppBundle\Entity\Manager\Interfaces\HeureTravailManagerInterface;
use Lpsa\AppBundle\Form\Type\HeureTravail\HeureTravailType;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractHeureTravailFormHandlerStrategy implements HeureTravailFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var HeureTravailManagerInterface
     */
    protected $heureTravailManager;
 
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
     *
     * @var HeureTravailType 
     */
    protected $heureTravailType;

    /**
     * 
     * @param HeureTravailType $heureTravailType
     */
    public function __construct(HeureTravailType $heureTravailType) {
        $this->heureTravailType = $heureTravailType;
    }
    /**
     * @param HeureTravailManagerInterface $heureTravailManager
     * @return AbstractHeureTravailFormHandlerStrategy
     */
    public function setHeureTravailManager($heureTravailManager)
    {
        $this->heureTravailManager = $heureTravailManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractHeureTravailFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractHeureTravailFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractHeureTravailFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, HeureTravail $heureTravail);
 
    abstract public function createForm(HeureTravail $heureTravail);
}
