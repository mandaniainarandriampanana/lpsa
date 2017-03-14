<?php

namespace Lpsa\AppBundle\Repository;
use Lpsa\CoreBundle\Repository\AbstractGenericRepository;
/**
 * VisiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VisiteRepository extends AbstractGenericRepository
{
    public function findAllByYear($year){
        $qb = $this->createQueryBuilder('visite');
        $qb->select('visite')
            ->where('visite.annee = :year')
            ->setParameter('year',$year)
        ;
        $qb->orderBy('visite.mois','ASC');

        return $qb->getQuery()->getResult();
    }
}