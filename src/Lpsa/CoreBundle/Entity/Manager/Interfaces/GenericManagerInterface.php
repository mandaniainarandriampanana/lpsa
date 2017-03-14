<?php

namespace Lpsa\CoreBundle\Entity\Manager\Interfaces;

interface GenericManagerInterface {
    
    /**
     * @param $entity
     */
    public function remove($entity);
    
    /**
     * @param $entity
     * @param bool $persist
     * @param bool $flush
     * @return mixed
     */
    public function save($entity, $persist = false, $flush = true);
    
    public function getRepository();
}
