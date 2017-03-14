<?php

namespace Lpsa\AppBundle\Form\Handler\EvenementCategorie;

use Lpsa\AppBundle\Entity\EvenementCategorie;
use Lpsa\AppBundle\Entity\Manager\Interfaces\EvenementCategorieManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractEvenementCategorieFormHandlerStrategy implements EvenementCategorieFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var EvenementCategorieManagerInterface
     */
    protected $evenementcategorieManager;
 
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
     * @param EvenementCategorieManagerInterface $evenementcategorieManager
     * @return AbstractEvenementCategorieFormHandlerStrategy
     */
    public function setEvenementCategorieManager($evenementcategorieManager)
    {
        $this->evenementcategorieManager = $evenementcategorieManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractEvenementCategorieFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractEvenementCategorieFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractEvenementCategorieFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, EvenementCategorie $evenementcategorie);
 
    abstract public function createForm(EvenementCategorie $evenementcategorie);
}
