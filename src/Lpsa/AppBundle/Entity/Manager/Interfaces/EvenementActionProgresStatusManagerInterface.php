<?php

namespace Lpsa\AppBundle\Entity\Manager\Interfaces;
use Lpsa\CoreBundle\Entity\Manager\Interfaces\GenericManagerInterface;

Interface EvenementActionProgresStatusManagerInterface extends GenericManagerInterface{
    /**
     * @param FormFactoryInterface $formFactory
     * @return EvenementActionProgresStatusManagerInterface
     */
    public function setFormFactory($formFactory);
    /**
     * @param RouterInterface $router
     * @return EvenementActionProgresStatusManagerInterface
     */
    public function setRouter($router);
}
