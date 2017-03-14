<?php

namespace Lpsa\AppBundle\Form\Handler\Environnement;

use Lpsa\AppBundle\Entity\Environnement;
use Lpsa\AppBundle\Entity\Manager\Interfaces\EnvironnementManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractEnvironnementFormHandlerStrategy implements EnvironnementFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var EnvironnementManagerInterface
     */
    protected $environnementManager;
 
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
     * @param EnvironnementManagerInterface $environnementManager
     * @return AbstractEnvironnementFormHandlerStrategy
     */
    public function setEnvironnementManager($environnementManager)
    {
        $this->environnementManager = $environnementManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractEnvironnementFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractEnvironnementFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractEnvironnementFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, Environnement $environnement);
 
    abstract public function createForm(Environnement $environnement);
}
