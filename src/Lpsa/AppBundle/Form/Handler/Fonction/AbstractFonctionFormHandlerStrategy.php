<?php

namespace Lpsa\AppBundle\Form\Handler\Fonction;

use Lpsa\AppBundle\Entity\Fonction;
use Lpsa\AppBundle\Entity\Manager\Interfaces\FonctionManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractFonctionFormHandlerStrategy implements FonctionFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var FonctionManagerInterface
     */
    protected $fonctionManager;
 
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
     * @param FonctionManagerInterface $fonctionManager
     * @return AbstractFonctionFormHandlerStrategy
     */
    public function setFonctionManager($fonctionManager)
    {
        $this->fonctionManager = $fonctionManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractFonctionFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractFonctionFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractFonctionFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, Fonction $fonction);
 
    abstract public function createForm(Fonction $fonction);
}
