<?php

namespace Lpsa\AppBundle\Form\Handler\Corporel;

use Lpsa\AppBundle\Entity\Corporel;
use Lpsa\AppBundle\Entity\Manager\Interfaces\CorporelManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractCorporelFormHandlerStrategy implements CorporelFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var CorporelManagerInterface
     */
    protected $corporelManager;
 
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
     * @param CorporelManagerInterface $corporelManager
     * @return AbstractCorporelFormHandlerStrategy
     */
    public function setCorporelManager($corporelManager)
    {
        $this->corporelManager = $corporelManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractCorporelFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractCorporelFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractCorporelFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, Corporel $corporel);
 
    abstract public function createForm(Corporel $corporel);
}
