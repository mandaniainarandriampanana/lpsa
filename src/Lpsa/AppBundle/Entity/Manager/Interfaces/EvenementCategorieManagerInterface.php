<?php

namespace Lpsa\AppBundle\Entity\Manager\Interfaces;
use Lpsa\CoreBundle\Entity\Manager\Interfaces\GenericManagerInterface;

Interface EvenementCategorieManagerInterface extends GenericManagerInterface{
    /**
     * @param FormFactoryInterface $formFactory
     * @return EvenementCategorieManagerInterface
     */
    public function setFormFactory($formFactory);
    /**
     * @param RouterInterface $router
     * @return EvenementCategorieManagerInterface
     */
    public function setRouter($router);
}
