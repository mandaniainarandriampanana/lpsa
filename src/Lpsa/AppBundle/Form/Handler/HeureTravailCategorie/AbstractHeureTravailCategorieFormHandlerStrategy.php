<?php

namespace Lpsa\AppBundle\Form\Handler\HeureTravailCategorie;

use Lpsa\AppBundle\Entity\HeureTravailCategorie;
use Lpsa\AppBundle\Entity\Manager\Interfaces\HeureTravailCategorieManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractHeureTravailCategorieFormHandlerStrategy implements HeureTravailCategorieFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var HeureTravailCategorieManagerInterface
     */
    protected $heureTravailCategorieManager;
 
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
     * @param HeureTravailCategorieManagerInterface $heureTravailCategorieManager
     * @return AbstractHeureTravailCategorieFormHandlerStrategy
     */
    public function setHeureTravailCategorieManager($heureTravailCategorieManager)
    {
        $this->heureTravailCategorieManager = $heureTravailCategorieManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractHeureTravailCategorieFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractHeureTravailCategorieFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractHeureTravailCategorieFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, HeureTravailCategorie $heureTravailCategorie);
 
    abstract public function createForm(HeureTravailCategorie $heureTravailCategorie);
}
