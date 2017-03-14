<?php

namespace Lpsa\AppBundle\Form\Handler\Visite;

use Lpsa\AppBundle\Entity\Visite;
use Lpsa\AppBundle\Entity\Manager\Interfaces\VisiteManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractVisiteFormHandlerStrategy implements VisiteFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var VisiteManagerInterface
     */
    protected $visiteManager;
 
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
     * @param VisiteManagerInterface $visiteManager
     * @return AbstractVisiteFormHandlerStrategy
     */
    public function setVisiteManager($visiteManager)
    {
        $this->visiteManager = $visiteManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractVisiteFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractVisiteFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractVisiteFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, Visite $visite);
 
    abstract public function createForm(Visite $visite);
}
