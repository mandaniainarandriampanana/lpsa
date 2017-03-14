<?php

namespace Lpsa\AppBundle\Form\Handler\TypeCorporel;

use Lpsa\AppBundle\Entity\TypeCorporel;
use Lpsa\AppBundle\Entity\Manager\Interfaces\TypeCorporelManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractTypeCorporelFormHandlerStrategy implements TypeCorporelFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var TypeCorporelManagerInterface
     */
    protected $typecorporelManager;
 
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
     * @param TypeCorporelManagerInterface $typecorporelManager
     * @return AbstractTypeCorporelFormHandlerStrategy
     */
    public function setTypeCorporelManager($typecorporelManager)
    {
        $this->typecorporelManager = $typecorporelManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractTypeCorporelFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractTypeCorporelFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractTypeCorporelFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, TypeCorporel $typecorporel);
 
    abstract public function createForm(TypeCorporel $typecorporel);
}
