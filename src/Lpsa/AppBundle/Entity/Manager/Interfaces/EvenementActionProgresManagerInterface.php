<?php

namespace Lpsa\AppBundle\Entity\Manager\Interfaces;

use Lpsa\CoreBundle\Entity\Manager\Interfaces\GenericManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;

interface EvenementActionProgresManagerInterface extends GenericManagerInterface{
    
    /**
     * @param FormFactoryInterface $formFactory
     * @return EvenementActionProgresManagerInterface
     */
    public function setFormFactory($formFactory);
    /**
     * 
     * @param type $router
     */
    public function setRouter($router);
}
