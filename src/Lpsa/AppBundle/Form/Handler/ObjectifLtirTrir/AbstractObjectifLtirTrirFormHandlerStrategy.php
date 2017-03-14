<?php

namespace Lpsa\AppBundle\Form\Handler\ObjectifLtirTrir;

use Lpsa\AppBundle\Entity\ObjectifLtirTrir;
use Lpsa\AppBundle\Entity\Manager\Interfaces\ObjectifLtirTrirManagerInterface;
use Lpsa\AppBundle\Form\Type\ObjectifLtirTrir\ObjectifLtirTrirType;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractObjectifLtirTrirFormHandlerStrategy implements ObjectifLtirTrirFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var ObjectifLtirTrirManagerInterface
     */
    protected $objectifLtirTrirManager;
 
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
     * @var ObjectifLtirTrirType 
     */
    protected $objectifLtirTrirType;

    /**
     * 
     * @param ObjectifLtirTrirType $objectifLtirTrirType
     */
    public function __construct(ObjectifLtirTrirType $objectifLtirTrirType) {
        $this->objectifLtirTrirType = $objectifLtirTrirType;
    }
    /**
     * @param ObjectifLtirTrirManagerInterface $objectifLtirTrirManager
     * @return AbstractObjectifLtirTrirFormHandlerStrategy
     */
    public function setObjectifLtirTrirManager($objectifLtirTrirManager)
    {
        $this->objectifLtirTrirManager = $objectifLtirTrirManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractObjectifLtirTrirFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractObjectifLtirTrirFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractObjectifLtirTrirFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, ObjectifLtirTrir $objectifLtirTrir);
 
    abstract public function createForm(ObjectifLtirTrir $objectifLtirTrir);
}
