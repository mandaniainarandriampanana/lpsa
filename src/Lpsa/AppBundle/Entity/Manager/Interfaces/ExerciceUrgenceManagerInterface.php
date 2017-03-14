<?php

namespace Lpsa\AppBundle\Entity\Manager\Interfaces;

use Lpsa\CoreBundle\Entity\Manager\Interfaces\GenericManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;

interface ExerciceUrgenceManagerInterface extends GenericManagerInterface{
    
    /**
     * @param FormFactoryInterface $formFactory
     * @return ExerciceUrgenceManagerInterface
     */
    public function setFormFactory($formFactory);
    /**
     * @param RouterInterface $router
     * @return ExerciceUrgenceManagerInterface
     */
    public function setRouter($router);
}
