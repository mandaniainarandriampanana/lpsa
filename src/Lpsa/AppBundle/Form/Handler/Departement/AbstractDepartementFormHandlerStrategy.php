<?php

namespace Lpsa\AppBundle\Form\Handler\Departement;

use Lpsa\AppBundle\Entity\Departement;
use Lpsa\AppBundle\Entity\Manager\Interfaces\DepartementManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractDepartementFormHandlerStrategy implements DepartementFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var DepartementManagerInterface
     */
    protected $departementManager;
 
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
     * @param DepartementManagerInterface $departementManager
     * @return AbstractDepartementFormHandlerStrategy
     */
    public function setDepartementManager($departementManager)
    {
        $this->departementManager = $departementManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractDepartementFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractDepartementFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractDepartementFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, Departement $departement);
 
    abstract public function createForm(Departement $departement);
}
