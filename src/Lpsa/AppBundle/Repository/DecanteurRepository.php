<?php

namespace Lpsa\AppBundle\Repository;
use Lpsa\CoreBundle\Repository\AbstractGenericRepository;
/**
 * DecanteurRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DecanteurRepository extends AbstractGenericRepository
{
    public function findAllByYear($year){
        $qb = $this->createQueryBuilder('decanteur');
        $qb->select('decanteur')
            ->where('decanteur.annee = :year')
            ->setParameter('year',$year)
        ;
        $qb->orderBy('decanteur.mois','ASC');

        return $qb->getQuery()->getResult();
    }
}
