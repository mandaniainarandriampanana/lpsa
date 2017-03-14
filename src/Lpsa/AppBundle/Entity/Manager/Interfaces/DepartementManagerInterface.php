<?php

namespace Lpsa\AppBundle\Entity\Manager\Interfaces;

use Lpsa\CoreBundle\Entity\Manager\Interfaces\GenericManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;

interface DepartementManagerInterface extends GenericManagerInterface{
    
     /**
     * @param FormFactoryInterface $formFactory
     * @return DepartementManagerInterface
     */
    public function setFormFactory($formFactory);
    /**
     * @param RouterInterface $router
     * @return DepartementManagerInterface
     */
    public function setRouter($router);
}
