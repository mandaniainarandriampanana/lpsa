<?php

namespace Lpsa\AppBundle\Repository;

use Lpsa\CoreBundle\Repository\AbstractGenericRepository;

/**
 * ExerciceUrgenceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ExerciceUrgenceRepository extends AbstractGenericRepository
{
    public function findAllByYear($year){
        $qb = $this->createQueryBuilder('ex');
        $qb->select('ex')
            ->where('ex.annee = :year')
            ->setParameter('year',$year)
        ;
        $qb->orderBy('ex.mois','ASC');

        return $qb->getQuery()->getResult();
    }
}
