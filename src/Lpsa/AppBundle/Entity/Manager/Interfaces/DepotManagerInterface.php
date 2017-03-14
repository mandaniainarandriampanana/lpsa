<?php

namespace Lpsa\AppBundle\Entity\Manager\Interfaces;
use Lpsa\CoreBundle\Entity\Manager\Interfaces\GenericManagerInterface;

Interface DepotManagerInterface extends GenericManagerInterface{
    /**
     * @param FormFactoryInterface $formFactory
     * @return DepotManagerInterface
     */
    public function setFormFactory($formFactory);
    /**
     * @param RouterInterface $router
     * @return DepotManagerInterface
     */
    public function setRouter($router);
}
