<?php

namespace Lpsa\AppBundle\Entity\Manager;

use Lpsa\AppBundle\Entity\Manager\Interfaces\HeureTravailManagerInterface;
use Lpsa\CoreBundle\Entity\Manager\AbstractGenericManager;

class HeureTravailManager extends AbstractGenericManager implements HeureTravailManagerInterface{
    /**
     * @var FormTypeInterface
     */
    protected $searchFormType;
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;
    /**
     * @var RouterInterface $router
     */
    protected $router;
    
    /**
     * @inheritdoc
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @inheritdoc
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
}
