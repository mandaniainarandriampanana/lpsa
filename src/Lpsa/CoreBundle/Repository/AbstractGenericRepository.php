<?php

namespace Lpsa\CoreBundle\Repository;

use Lpsa\CoreBundle\Repository\Interfaces\GenericRepositoryInterface;

class AbstractGenericRepository extends \Doctrine\ORM\EntityRepository implements GenericRepositoryInterface{
    /**
     * @inheritdoc
     */
    public function remove($entity)
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }
    
    /**
     * {@inheritdoc}
     */
    public function save($entity, $persist = false, $flush = true)
    {
        if ($persist) {
            $this->_em->persist($entity);
        }
        if ($flush) {
            $this->_em->flush();
        }
        return $entity;
    }
}
