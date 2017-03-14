<?php

namespace Lpsa\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository{
    public function findLike($tags){
        $select="SELECT u FROM LpsaUserBundle:User u";
        $condition=" WHERE u.matricule LIKE '".$tags."%'"
                ." OR u.firstname LIKE '".$tags."%'"
                ." OR u.lastname LIKE '".$tags."%'";
                
        
        $query=$this->_em->createQuery($select." ".$condition);
        return $query->getResult();
    }
}
