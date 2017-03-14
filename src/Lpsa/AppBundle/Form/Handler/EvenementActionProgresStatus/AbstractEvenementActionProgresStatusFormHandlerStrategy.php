<?php

namespace Lpsa\AppBundle\Form\Handler\EvenementActionProgresStatus;

use Lpsa\AppBundle\Entity\EvenementActionProgresStatus;
use Lpsa\AppBundle\Entity\Manager\Interfaces\EvenementActionProgresStatusManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractEvenementActionProgresStatusFormHandlerStrategy implements EvenementActionProgresStatusFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var EvenementActionProgresStatusManagerInterface
     */
    protected $evenementactionprogresstatusManager;
 
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
     * @param EvenementActionProgresStatusManagerInterface $evenementactionprogresstatusManager
     * @return AbstractEvenementActionProgresStatusFormHandlerStrategy
     */
    public function setEvenementActionProgresStatusManager($evenementactionprogresstatusManager)
    {
        $this->evenementactionprogresstatusManager = $evenementactionprogresstatusManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractEvenementActionProgresStatusFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractEvenementActionProgresStatusFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractEvenementActionProgresStatusFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, EvenementActionProgresStatus $evenementactionprogresstatus);
 
    abstract public function createForm(EvenementActionProgresStatus $evenementactionprogresstatus);
}
