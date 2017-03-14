<?php

namespace Lpsa\CoreBundle\Entity\Manager;

use Lpsa\CoreBundle\Entity\Manager\Interfaces\GenericManagerInterface;
use Lpsa\CoreBundle\Repository\Interfaces\GenericRepositoryInterface;

class AbstractGenericManager implements GenericManagerInterface{
    /**
     * @var GenericRepositoryInterface $repository
     */
    protected $repository;
    /**
     * @inheritdoc
     */
    public function __construct(GenericRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * @inheritdoc
     */
    public function remove($entity)
    {
        $this->repository->remove($entity);
    }
    
    /**
     * @inheritdoc
     */
    public function save($entity, $persist = false, $flush = true)
    {
        return $this->repository->save($entity, $persist, $flush);
    }
    
    public function getRepository(){
        return $this->repository;
    }    
}
