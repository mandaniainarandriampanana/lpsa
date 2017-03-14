<?php

namespace Lpsa\AppBundle\Form\Handler\Toolbox;

use Lpsa\AppBundle\Entity\Toolbox;
use Lpsa\AppBundle\Entity\Manager\Interfaces\ToolboxManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Lpsa\AppBundle\Form\Type\Toolbox\ToolboxType;

abstract class AbstractToolboxFormHandlerStrategy implements ToolboxFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var ToolboxManagerInterface
     */
    protected $toolboxManager;
 
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
     * @param ToolboxType $toolboxType
     */
    public function __construct(ToolboxType $toolboxType) {
        $this->toolboxType = $toolboxType;
    }
 
    /**
     * @param ToolboxManagerInterface $toolboxManager
     * @return AbstractToolboxFormHandlerStrategy
     */
    public function setToolboxManager($toolboxManager)
    {
        $this->toolboxManager = $toolboxManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractToolboxFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractToolboxFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractToolboxFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, Toolbox $toolbox);
 
    abstract public function createForm(Toolbox $toolbox);
}
