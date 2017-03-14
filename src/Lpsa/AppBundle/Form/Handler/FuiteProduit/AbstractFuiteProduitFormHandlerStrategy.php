<?php

namespace Lpsa\AppBundle\Form\Handler\FuiteProduit;

use Lpsa\AppBundle\Entity\FuiteProduit;
use Lpsa\AppBundle\Entity\Manager\Interfaces\FuiteProduitManagerInterface;
use Lpsa\AppBundle\Form\Type\FuiteProduit\FuiteProduitType;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractFuiteProduitFormHandlerStrategy implements FuiteProduitFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var FuiteProduitManagerInterface
     */
    protected $fuiteProduitManager;
 
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
     * @var FuiteProduitType 
     */
    protected $fuiteProduitType;

    /**
     * 
     * @param FuiteProduitType $fuiteProduitType
     */
    public function __construct(FuiteProduitType $fuiteProduitType) {
        $this->fuiteProduitType = $fuiteProduitType;
    }
 
    /**
     * @param FuiteProduitManagerInterface $fuiteProduitManager
     * @return AbstractFuiteProduitFormHandlerStrategy
     */
    public function setFuiteProduitManager($fuiteProduitManager)
    {
        $this->fuiteProduitManager = $fuiteProduitManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractFuiteProduitFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractFuiteProduitFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractFuiteProduitFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, FuiteProduit $fuiteProduit);
 
    abstract public function createForm(FuiteProduit $fuiteProduit);
}
