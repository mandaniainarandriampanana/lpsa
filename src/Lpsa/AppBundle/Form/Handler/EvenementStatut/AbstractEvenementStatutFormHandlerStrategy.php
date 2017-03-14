<?php

namespace Lpsa\AppBundle\Form\Handler\EvenementStatut;

use Lpsa\AppBundle\Entity\EvenementStatut;
use Lpsa\AppBundle\Entity\Manager\Interfaces\EvenementStatutManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractEvenementStatutFormHandlerStrategy implements EvenementStatutFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var EvenementStatutManagerInterface
     */
    protected $evenementStatutManager;
 
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
     * @param EvenementStatutManagerInterface $evenementStatutManager
     * @return AbstractEvenementStatutFormHandlerStrategy
     */
    public function setEvenementStatutManager($evenementStatutManager)
    {
        $this->evenementStatutManager = $evenementStatutManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractEvenementStatutFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractEvenementStatutFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractEvenementStatutFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, EvenementStatut $evenementStatut);
 
    abstract public function createForm(EvenementStatut $evenementStatut);
}
