<?php

namespace Lpsa\AppBundle\Form\Handler\ResponsableService;

use Lpsa\AppBundle\Entity\ResponsableService;
use Lpsa\AppBundle\Entity\Manager\Interfaces\ResponsableServiceManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractResponsableServiceFormHandlerStrategy implements ResponsableServiceFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var ResponsableServiceManagerInterface
     */
    protected $responsableServiceManager;
 
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
     * @param ResponsableServiceManagerInterface $responsableServiceManager
     * @return AbstractResponsableServiceFormHandlerStrategy
     */
    public function setResponsableServiceManager($responsableServiceManager)
    {
        $this->responsableServiceManager = $responsableServiceManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractResponsableServiceFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractResponsableServiceFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractResponsableServiceFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, ResponsableService $responsableService);
 
    abstract public function createForm(ResponsableService $responsableService);
}
