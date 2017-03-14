<?php

namespace Lpsa\AppBundle\Form\Handler\Laboratoire;

use Lpsa\AppBundle\Entity\Laboratoire;
use Lpsa\AppBundle\Entity\Manager\Interfaces\LaboratoireManagerInterface;
use Lpsa\AppBundle\Form\Type\Laboratoire\LaboratoireType;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractLaboratoireFormHandlerStrategy implements LaboratoireFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var LaboratoireManagerInterface
     */
    protected $laboratoireManager;
 
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
     * @var LaboratoireType 
     */
    protected $laboratoireType;

    /**
     * 
     * @param LaboratoireType $laboratoireType
     */
    public function __construct(LaboratoireType $laboratoireType) {
        $this->laboratoireType = $laboratoireType;
    }
    /**
     * @param LaboratoireManagerInterface $laboratoireManager
     * @return AbstractLaboratoireFormHandlerStrategy
     */
    public function setLaboratoireManager($laboratoireManager)
    {
        $this->laboratoireManager = $laboratoireManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractLaboratoireFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractLaboratoireFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractLaboratoireFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, Laboratoire $laboratoire);
 
    abstract public function createForm(Laboratoire $laboratoire);
}
