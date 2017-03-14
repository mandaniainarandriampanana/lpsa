<?php

namespace Lpsa\AppBundle\Form\Handler\Materiel;

use Lpsa\AppBundle\Entity\Materiel;
use Lpsa\AppBundle\Entity\Manager\Interfaces\MaterielManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractMaterielFormHandlerStrategy implements MaterielFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var MaterielManagerInterface
     */
    protected $materielManager;
 
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
     * @param MaterielManagerInterface $materielManager
     * @return AbstractMaterielFormHandlerStrategy
     */
    public function setMaterielManager($materielManager)
    {
        $this->materielManager = $materielManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractMaterielFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractMaterielFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractMaterielFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, Materiel $materiel);
 
    abstract public function createForm(Materiel $materiel);
}
