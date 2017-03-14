<?php

namespace Lpsa\AppBundle\Form\Handler\Decanteur;

use Lpsa\AppBundle\Entity\Decanteur;
use Lpsa\AppBundle\Entity\Manager\Interfaces\DecanteurManagerInterface;
use Lpsa\AppBundle\Form\Type\Decanteur\DecanteurType;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractDecanteurFormHandlerStrategy implements DecanteurFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var DecanteurManagerInterface
     */
    protected $decanteurManager;
 
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
     * @var DecanteurType 
     */
    protected $decanteurType;

    /**
     * 
     * @param DecanteurType $decanteurType
     */
    public function __construct(DecanteurType $decanteurType) {
        $this->decanteurType = $decanteurType;
    }
    /**
     * @param DecanteurManagerInterface $decanteurManager
     * @return AbstractDecanteurFormHandlerStrategy
     */
    public function setDecanteurManager($decanteurManager)
    {
        $this->decanteurManager = $decanteurManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractDecanteurFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractDecanteurFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractDecanteurFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, Decanteur $decanteur);
 
    abstract public function createForm(Decanteur $decanteur);
}
