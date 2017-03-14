<?php

namespace Lpsa\AppBundle\Form\Handler\PAQSSSE;

use Lpsa\AppBundle\Entity\PAQSSSE;
use Lpsa\AppBundle\Entity\Manager\Interfaces\PAQSSSEManagerInterface;
use Lpsa\AppBundle\Form\Type\PAQSSSE\PAQSSSEType;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractPAQSSSEFormHandlerStrategy implements PAQSSSEFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var PAQSSSEManagerInterface
     */
    protected $PAQSSSEManager;
 
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
     * @var PAQSSSEType 
     */
    protected $PAQSSSEType;

    /**
     * 
     * @param PAQSSSEType $PAQSSSEType
     */
    public function __construct(PAQSSSEType $PAQSSSEType) {
        $this->PAQSSSEType = $PAQSSSEType;
    }
    /**
     * @param PAQSSSEManagerInterface $PAQSSSEManager
     * @return AbstractPAQSSSEFormHandlerStrategy
     */
    public function setPAQSSSEManager($PAQSSSEManager)
    {
        $this->PAQSSSEManager = $PAQSSSEManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractPAQSSSEFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractPAQSSSEFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractPAQSSSEFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, PAQSSSE $PAQSSSE);
 
    abstract public function createForm(PAQSSSE $PAQSSSE);
}
