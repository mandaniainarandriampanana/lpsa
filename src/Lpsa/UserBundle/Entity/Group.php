<?php

namespace Lpsa\UserBundle\Entity;

use FOS\UserBundle\Entity\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_group")
 */
class Group extends BaseGroup{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var Depot
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Depot")
     * @ORM\JoinColumn(name="depot_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $depot;
    
    public function __construct($name, $roles = array())
    {
        parent::__construct($name, $roles);
    }

    /**
     * Set depot
     *
     * @param \Lpsa\AppBundle\Entity\Depot $depot
     *
     * @return Group
     */
    public function setDepot(\Lpsa\AppBundle\Entity\Depot $depot = null)
    {
        $this->depot = $depot;

        return $this;
    }

    /**
     * Get depot
     *
     * @return \Lpsa\AppBundle\Entity\Depot
     */
    public function getDepot()
    {
        return $this->depot;
    }
}
