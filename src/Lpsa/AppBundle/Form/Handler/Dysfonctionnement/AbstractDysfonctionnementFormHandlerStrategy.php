<?php

namespace Lpsa\AppBundle\Form\Handler\Dysfonctionnement;

use Lpsa\AppBundle\Entity\Dysfonctionnement;
use Lpsa\AppBundle\Entity\Manager\Interfaces\DysfonctionnementManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractDysfonctionnementFormHandlerStrategy implements DysfonctionnementFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var DysfonctionnementManagerInterface
     */
    protected $dysfonctionnementManager;
 
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
     * @param DysfonctionnementManagerInterface $dysfonctionnementManager
     * @return AbstractDysfonctionnementFormHandlerStrategy
     */
    public function setDysfonctionnementManager($dysfonctionnementManager)
    {
        $this->dysfonctionnementManager = $dysfonctionnementManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractDysfonctionnementFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractDysfonctionnementFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractDysfonctionnementFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, Dysfonctionnement $dysfonctionnement);
 
    abstract public function createForm(Dysfonctionnement $dysfonctionnement);
}
