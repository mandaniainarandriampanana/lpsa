<?php

namespace Lpsa\AppBundle\Entity\Manager\Interfaces;

use Lpsa\CoreBundle\Entity\Manager\Interfaces\GenericManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;

interface LaboratoireManagerInterface extends GenericManagerInterface{
    
     /**
     * @param FormFactoryInterface $formFactory
     * @return LaboratoireManagerInterface
     */
    public function setFormFactory($formFactory);
    /**
     * @param RouterInterface $router
     * @return LaboratoireManagerInterface
     */
    public function setRouter($router);
}
