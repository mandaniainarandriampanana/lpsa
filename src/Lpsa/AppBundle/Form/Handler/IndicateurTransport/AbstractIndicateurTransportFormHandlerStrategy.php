<?php

namespace Lpsa\AppBundle\Form\Handler\IndicateurTransport;

use Lpsa\AppBundle\Entity\IndicateurTransport;
use Lpsa\AppBundle\Entity\Manager\Interfaces\IndicateurTransportManagerInterface;
use Lpsa\AppBundle\Form\Type\IndicateurTransport\IndicateurTransportType;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractIndicateurTransportFormHandlerStrategy implements IndicateurTransportFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var IndicateurTransportManagerInterface
     */
    protected $indicateurTransportManager;
 
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
     * @var IndicateurTransportType 
     */
    protected $indicateurTransportType;

    /**
     * 
     * @param IndicateurTransportType $indicateurTransportType
     */
    public function __construct(IndicateurTransportType $indicateurTransportType) {
        $this->indicateurTransportType = $indicateurTransportType;
    }
    /**
     * @param IndicateurTransportManagerInterface $indicateurTransportManager
     * @return AbstractIndicateurTransportFormHandlerStrategy
     */
    public function setIndicateurTransportManager($indicateurTransportManager)
    {
        $this->indicateurTransportManager = $indicateurTransportManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractIndicateurTransportFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractIndicateurTransportFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractIndicateurTransportFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, IndicateurTransport $indicateurTransport);
 
    abstract public function createForm(IndicateurTransport $indicateurTransport);
}
