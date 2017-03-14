<?php

namespace Lpsa\AppBundle\Form\Handler\ObjectifKpihse;

use Lpsa\AppBundle\Entity\ObjectifKpihse;
use Lpsa\AppBundle\Entity\Manager\Interfaces\ObjectifKpihseManagerInterface;
use Lpsa\AppBundle\Form\Type\ObjectifKpihse\ObjectifKpihseType;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractObjectifKpihseFormHandlerStrategy implements ObjectifKpihseFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var ObjectifKpihseManagerInterface
     */
    protected $objectifKpihseManager;
 
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
     *
     * @var ObjectifKpihseType 
     */
    protected $objectifKpihseType;

    /**
     * 
     * @param ObjectifKpihseType $objectifKpihseType
     */
    public function __construct(ObjectifKpihseType $objectifKpihseType) {
        $this->objectifKpihseType = $objectifKpihseType;
    }
    /**
     * @param ObjectifKpihseManagerInterface $objectifKpihseManager
     * @return AbstractObjectifKpihseFormHandlerStrategy
     */
    public function setObjectifKpihseManager($objectifKpihseManager)
    {
        $this->objectifKpihseManager = $objectifKpihseManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractObjectifKpihseFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractObjectifKpihseFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractObjectifKpihseFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, ObjectifKpihse $objectifKpihse);
 
    abstract public function createForm(ObjectifKpihse $objectifKpihse);
}
