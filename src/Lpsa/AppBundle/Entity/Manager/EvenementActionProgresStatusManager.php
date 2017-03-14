<?php

namespace Lpsa\AppBundle\Entity\Manager;

use Lpsa\AppBundle\Entity\Manager\Interfaces\EvenementActionProgresStatusManagerInterface;
use Lpsa\CoreBundle\Entity\Manager\AbstractGenericManager;

class EvenementActionProgresStatusManager extends AbstractGenericManager implements EvenementActionProgresStatusManagerInterface{
    /**
     *
     * @var type 
     */
    protected $searchFormType;
    /**
     *
     * @var type 
     */
    protected $formFactory;
   /**
    *
    * @var type 
    */
    protected $router;
    
    /**
     * 
     * @param type $formFactory
     * @return \Lpsa\AppBundle\Entity\Manager\EvenementActionProgresStatusManager
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * 
     * @param type $router
     * @return \Lpsa\AppBundle\Entity\Manager\EvenementActionProgresStatusManager
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
}