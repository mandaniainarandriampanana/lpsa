<?php

namespace Lpsa\AppBundle\Form\Handler\Piezometre;

use Lpsa\AppBundle\Entity\Piezometre;
use Lpsa\AppBundle\Entity\Manager\Interfaces\PiezometreManagerInterface;
use Lpsa\AppBundle\Form\Type\Piezometre\PiezometreType;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractPiezometreFormHandlerStrategy implements PiezometreFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var PiezometreManagerInterface
     */
    protected $piezometreManager;
 
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
     * @var PiezometreType 
     */
    protected $piezometreType;

    /**
     * 
     * @param PiezometreType $piezometreType
     */
    public function __construct(PiezometreType $piezometreType) {
        $this->piezometreType = $piezometreType;
    }
    /**
     * @param PiezometreManagerInterface $piezometreManager
     * @return AbstractPiezometreFormHandlerStrategy
     */
    public function setPiezometreManager($piezometreManager)
    {
        $this->piezometreManager = $piezometreManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractPiezometreFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractPiezometreFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractPiezometreFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, Piezometre $piezometre);
 
    abstract public function createForm(Piezometre $piezometre);
}
