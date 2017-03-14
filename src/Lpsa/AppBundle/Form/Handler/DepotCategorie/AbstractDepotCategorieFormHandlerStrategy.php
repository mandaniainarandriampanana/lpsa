<?php

namespace Lpsa\AppBundle\Form\Handler\DepotCategorie;

use Lpsa\AppBundle\Entity\DepotCategorie;
use Lpsa\AppBundle\Entity\Manager\Interfaces\DepotCategorieManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractDepotCategorieFormHandlerStrategy implements DepotCategorieFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var DepotCategorieManagerInterface
     */
    protected $depotCategorieManager;
 
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
     * @param DepotCategorieManagerInterface $depotCategorieManager
     * @return AbstractDepotCategorieFormHandlerStrategy
     */
    public function setDepotCategorieManager($depotCategorieManager)
    {
        $this->depotCategorieManager = $depotCategorieManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractDepotCategorieFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractDepotCategorieFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractDepotCategorieFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, DepotCategorie $depotCategorie);
 
    abstract public function createForm(DepotCategorie $depotCategorie);
}
