<?php

namespace Lpsa\AppBundle\Form\Handler\TypeMateriel;

use Lpsa\AppBundle\Entity\TypeMateriel;
use Lpsa\AppBundle\Entity\Manager\Interfaces\TypeMaterielManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractTypeMaterielFormHandlerStrategy implements TypeMaterielFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var TypeMaterielManagerInterface
     */
    protected $typematerielManager;
 
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
     * @param TypeMaterielManagerInterface $typematerielManager
     * @return AbstractTypeMaterielFormHandlerStrategy
     */
    public function setTypeMaterielManager($typematerielManager)
    {
        $this->typematerielManager = $typematerielManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractTypeMaterielFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractTypeMaterielFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractTypeMaterielFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, TypeMateriel $typemateriel);
 
    abstract public function createForm(TypeMateriel $typemateriel);
}
