<?php

namespace Lpsa\AppBundle\Entity\Manager\Interfaces;

use Lpsa\CoreBundle\Entity\Manager\Interfaces\GenericManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;

interface Paq3seGraviteManagerInterface extends GenericManagerInterface{
    
    /**
     * @param FormFactoryInterface $formFactory
     * @return Paq3seGravite
     */
    public function setFormFactory($formFactory);
    /**
     * @param RouterInterface $router
     * @return Paq3seGravite
     */
    public function setRouter($router);
}
