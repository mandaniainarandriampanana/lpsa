<?php

namespace Lpsa\AppBundle\Form\Handler\Depot;

use Lpsa\AppBundle\Entity\Depot;
use Lpsa\AppBundle\Entity\Manager\Interfaces\DepotManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractDepotFormHandlerStrategy implements DepotFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var DepotManagerInterface
     */
    protected $depotManager;
 
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
     * @param DepotManagerInterface $depotManager
     * @return AbstractDepotFormHandlerStrategy
     */
    public function setDepotManager($depotManager)
    {
        $this->depotManager = $depotManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractDepotFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractDepotFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractDepotFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, Depot $depot);
 
    abstract public function createForm(Depot $depot);
}
