<?php

namespace Lpsa\AppBundle\Entity\Manager\Interfaces;

use Lpsa\CoreBundle\Entity\Manager\Interfaces\GenericManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;

interface ObjectifLtirTrirManagerInterface extends GenericManagerInterface{
    
    /**
     * @param FormFactoryInterface $formFactory
     * @return ObjectifLtirTrirManagerInterface
     */
    public function setFormFactory($formFactory);
    /**
     * @param RouterInterface $router
     * @return ObjectifLtirTrirManagerInterface
     */
    public function setRouter($router);
}
