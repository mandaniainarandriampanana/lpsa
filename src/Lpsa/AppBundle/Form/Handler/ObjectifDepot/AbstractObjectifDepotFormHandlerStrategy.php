<?php

namespace Lpsa\AppBundle\Form\Handler\ObjectifDepot;

use Lpsa\AppBundle\Entity\ObjectifDepot;
use Lpsa\AppBundle\Entity\Manager\Interfaces\ObjectifDepotManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractObjectifDepotFormHandlerStrategy implements ObjectifDepotFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var ObjectifDepotManagerInterface
     */
    protected $objectifdepotManager;
 
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
     * @param ObjectifDepotManagerInterface $objectifdepotManager
     * @return AbstractObjectifDepotFormHandlerStrategy
     */
    public function setObjectifDepotManager($objectifdepotManager)
    {
        $this->objectifdepotManager = $objectifdepotManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractObjectifDepotFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractObjectifDepotFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractObjectifDepotFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, ObjectifDepot $objectifdepot);
 
    abstract public function createForm(ObjectifDepot $objectifdepot);
}
