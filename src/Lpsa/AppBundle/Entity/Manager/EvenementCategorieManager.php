<?php

namespace Lpsa\AppBundle\Entity\Manager;

use Lpsa\AppBundle\Entity\Manager\Interfaces\EvenementCategorieManagerInterface;
use Lpsa\CoreBundle\Entity\Manager\AbstractGenericManager;

class EvenementCategorieManager extends AbstractGenericManager implements EvenementCategorieManagerInterface{
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
     * @return \Lpsa\AppBundle\Entity\Manager\EvenementCategorieManager
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * 
     * @param type $router
     * @return \Lpsa\AppBundle\Entity\Manager\EvenementCategorieManager
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
}