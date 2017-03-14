<?php

namespace Lpsa\AppBundle\Entity\Manager\Interfaces;

use Lpsa\CoreBundle\Entity\Manager\Interfaces\GenericManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;

interface EvenementStatutManagerInterface extends GenericManagerInterface{
    
    /**
     * @param FormFactoryInterface $formFactory
     * @return EvenementStatutManagerInterface
     */
    public function setFormFactory($formFactory);
    /**
     * @param RouterInterface $router
     * @return EvenementStatutManagerInterface
     */
    public function setRouter($router);
}
