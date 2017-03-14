<?php

namespace Lpsa\AppBundle\Form\Handler\ImpactClient;

use Lpsa\AppBundle\Entity\ImpactClient;
use Lpsa\AppBundle\Entity\Manager\Interfaces\ImpactClientManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractImpactClientFormHandlerStrategy implements ImpactClientFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var ImpactClientManagerInterface
     */
    protected $impactclientManager;
 
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
     * @param ImpactClientManagerInterface $impactclientManager
     * @return AbstractImpactClientFormHandlerStrategy
     */
    public function setImpactClientManager($impactclientManager)
    {
        $this->impactclientManager = $impactclientManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractImpactClientFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractImpactClientFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractImpactClientFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, ImpactClient $impactclient);
 
    abstract public function createForm(ImpactClient $impactclient);
}
