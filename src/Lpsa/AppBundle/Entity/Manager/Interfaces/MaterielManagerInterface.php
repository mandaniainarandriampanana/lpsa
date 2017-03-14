<?php

namespace Lpsa\AppBundle\Entity\Manager\Interfaces;

use Lpsa\CoreBundle\Entity\Manager\Interfaces\GenericManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;

interface MaterielManagerInterface extends GenericManagerInterface{
    
     /**
     * @param FormFactoryInterface $formFactory
     * @return MaterielManagerInterface
     */
    public function setFormFactory($formFactory);
    /**
     * @param RouterInterface $router
     * @return MaterielManagerInterface
     */
    public function setRouter($router);
}
