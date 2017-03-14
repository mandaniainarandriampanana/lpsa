<?php

namespace Lpsa\AppBundle\Repository;
use Lpsa\CoreBundle\Repository\AbstractGenericRepository;

/**
 * DepotRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DepotRepository extends AbstractGenericRepository
{
    /**
     * 
     * @param int $id
     * @return mixed
     */
    public function findAllDepotByDepotCategorie($id){
        $qb = $this->createQueryBuilder('depot');
        $qb->select('depot')
            ->innerJoin('depot.depotcategories', 'depotcategories')
            ->where('depotcategories.id = :id')
            ->setParameter('id', $id);
        $q = $qb->getQuery();

        return $q->getResult();
    }
}
