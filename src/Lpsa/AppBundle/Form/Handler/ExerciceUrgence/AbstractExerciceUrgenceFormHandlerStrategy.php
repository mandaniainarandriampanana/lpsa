<?php

namespace Lpsa\AppBundle\Form\Handler\ExerciceUrgence;

use Lpsa\AppBundle\Entity\ExerciceUrgence;
use Lpsa\AppBundle\Entity\Manager\Interfaces\ExerciceUrgenceManagerInterface;
use Lpsa\AppBundle\Form\Type\ExerciceUrgence\ExerciceUrgenceType;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractExerciceUrgenceFormHandlerStrategy implements ExerciceUrgenceFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var ExerciceUrgenceManagerInterface
     */
    protected $exerciceUrgenceManager;
 
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
     *
     * @var ExerciceUrgenceType 
     */
    protected $exerciceUrgenceType;

    /**
     * 
     * @param ExerciceUrgenceType $exerciceUrgenceType
     */
    public function __construct(ExerciceUrgenceType $exerciceUrgenceType) {
        $this->exerciceUrgenceType = $exerciceUrgenceType;
    }
    /**
     * @param ExerciceUrgenceManagerInterface $exerciceUrgenceManager
     * @return AbstractExerciceUrgenceFormHandlerStrategy
     */
    public function setExerciceUrgenceManager($exerciceUrgenceManager)
    {
        $this->exerciceUrgenceManager = $exerciceUrgenceManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractExerciceUrgenceFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractExerciceUrgenceFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractExerciceUrgenceFormHandlerStrategy
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
 
    abstract public function handleForm(Request $request, ExerciceUrgence $exerciceUrgence);
 
    abstract public function createForm(ExerciceUrgence $exerciceUrgence);
}
