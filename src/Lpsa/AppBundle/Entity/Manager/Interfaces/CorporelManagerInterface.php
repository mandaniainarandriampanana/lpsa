<?php

namespace Lpsa\AppBundle\Entity\Manager\Interfaces;

use Lpsa\CoreBundle\Entity\Manager\Interfaces\GenericManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;

interface CorporelManagerInterface extends GenericManagerInterface{
    
     /**
     * @param FormFactoryInterface $formFactory
     * @return CorporelManagerInterface
     */
    public function setFormFactory($formFactory);
    /**
     * @param RouterInterface $router
     * @return CorporelManagerInterface
     */
    public function setRouter($router);
}
