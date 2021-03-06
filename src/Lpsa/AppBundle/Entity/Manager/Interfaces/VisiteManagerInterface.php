<?php

namespace Lpsa\AppBundle\Entity\Manager\Interfaces;

use Lpsa\CoreBundle\Entity\Manager\Interfaces\GenericManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;

interface VisiteManagerInterface extends GenericManagerInterface{
    
     /**
     * @param FormFactoryInterface $formFactory
     * @return VisiteManagerInterface
     */
    public function setFormFactory($formFactory);
    /**
     * @param RouterInterface $router
     * @return VisiteManagerInterface
     */
    public function setRouter($router);
}
