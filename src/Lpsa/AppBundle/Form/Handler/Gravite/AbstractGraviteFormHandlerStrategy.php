<?php

namespace Lpsa\AppBundle\Form\Handler\Gravite;

use Lpsa\AppBundle\Entity\Gravite;
use Lpsa\AppBundle\Entity\Manager\Interfaces\GraviteManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractGraviteFormHandlerStrategy implements GraviteFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var GraviteManagerInterface
     */
    protected $graviteManager;
 
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
     * @param GraviteManagerInterface $graviteManager
     * @return AbstractGraviteFormHandlerStrategy
     */
    public function setGraviteManager($graviteManager)
    {
        $this->graviteManager = $graviteManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractGraviteFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractGraviteFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractGraviteFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, Gravite $gravite);
 
    abstract public function createForm(Gravite $gravite);
}
