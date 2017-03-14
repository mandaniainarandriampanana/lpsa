<?php

namespace Lpsa\AppBundle\Entity\Manager\Interfaces;

use Lpsa\CoreBundle\Entity\Manager\Interfaces\GenericManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;

interface FuiteProduitManagerInterface extends GenericManagerInterface{
    
    /**
     * @param FormFactoryInterface $formFactory
     * @return FuiteProduitManagerInterface
     */
    public function setFormFactory($formFactory);
    /**
     * @param RouterInterface $router
     * @return FuiteProduitManagerInterface
     */
    public function setRouter($router);
}
