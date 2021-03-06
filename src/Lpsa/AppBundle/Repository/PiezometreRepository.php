<?php

namespace Lpsa\AppBundle\Repository;
use Lpsa\CoreBundle\Repository\AbstractGenericRepository;
/**
 * PiezometreRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PiezometreRepository extends AbstractGenericRepository
{
    public function findAllByYear($year){
        $qb = $this->createQueryBuilder('piezometre');
        $qb->select('piezometre')
            ->where('piezometre.annee = :year')
            ->setParameter('year',$year)
        ;
        $qb->orderBy('piezometre.mois','ASC');

        return $qb->getQuery()->getResult();
    }
}
