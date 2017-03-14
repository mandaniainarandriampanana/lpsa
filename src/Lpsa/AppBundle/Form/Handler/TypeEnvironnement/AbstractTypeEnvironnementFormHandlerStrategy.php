<?php

namespace Lpsa\AppBundle\Form\Handler\TypeEnvironnement;

use Lpsa\AppBundle\Entity\TypeEnvironnement;
use Lpsa\AppBundle\Entity\Manager\Interfaces\TypeEnvironnementManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractTypeEnvironnementFormHandlerStrategy implements TypeEnvironnementFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var TypeEnvironnementManagerInterface
     */
    protected $typeenvironnementManager;
 
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
     * @param TypeEnvironnementManagerInterface $typeenvironnementManager
     * @return AbstractTypeEnvironnementFormHandlerStrategy
     */
    public function setTypeEnvironnementManager($typeenvironnementManager)
    {
        $this->typeenvironnementManager = $typeenvironnementManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractTypeEnvironnementFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractTypeEnvironnementFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractTypeEnvironnementFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, TypeEnvironnement $typeenvironnement);
 
    abstract public function createForm(TypeEnvironnement $typeenvironnement);
}
