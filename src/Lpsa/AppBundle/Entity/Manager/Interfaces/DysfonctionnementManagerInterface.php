<?php

namespace Lpsa\AppBundle\Entity\Manager\Interfaces;
use Lpsa\CoreBundle\Entity\Manager\Interfaces\GenericManagerInterface;

Interface DysfonctionnementManagerInterface extends GenericManagerInterface{
    /**
     * @param FormFactoryInterface $formFactory
     * @return DysfonctionnementManagerInterface
     */
    public function setFormFactory($formFactory);
    /**
     * @param RouterInterface $router
     * @return DysfonctionnementManagerInterface
     */
    public function setRouter($router);
}
