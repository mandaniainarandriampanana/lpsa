<?php

namespace Lpsa\AppBundle\Form\Handler\Paq3seGravite;

use Lpsa\AppBundle\Entity\Paq3seGravite;
use Lpsa\AppBundle\Entity\Manager\Interfaces\Paq3seGraviteManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractPaq3seGraviteFormHandlerStrategy implements Paq3seGraviteFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var Paq3seGraviteManagerInterface
     */
    protected $paq3seGraviteManager;
 
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
     * @param Paq3seGraviteManagerInterface $paq3seGraviteManager
     * @return AbstractPaq3seGraviteFormHandlerStrategy
     */
    public function setPaq3seGraviteManager($paq3seGraviteManager)
    {
        $this->paq3seGraviteManager = $paq3seGraviteManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractPaq3seGraviteFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractPaq3seGraviteFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractPaq3seGraviteFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, Paq3seGravite $paq3seGravite);
 
    abstract public function createForm(Paq3seGravite $paq3seGravite);
}
