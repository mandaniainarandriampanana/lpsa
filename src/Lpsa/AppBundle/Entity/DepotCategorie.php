<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DepotCategorie
 *
 * @ORM\Table(name="depot_categorie")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\DepotCategorieRepository")
 */
class DepotCategorie extends Base
{
    /**
    * @ORM\OnetoMany(targetEntity="Depot", mappedBy="depotcategories")
    */
    private $depot;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->depot = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add depot
     *
     * @param \Lpsa\AppBundle\Entity\Depot $depot
     *
     * @return DepotCategorie
     */
    public function addDepot(\Lpsa\AppBundle\Entity\Depot $depot)
    {
        $this->depot[] = $depot;

        return $this;
    }

    /**
     * Remove depot
     *
     * @param \Lpsa\AppBundle\Entity\Depot $depot
     */
    public function removeDepot(\Lpsa\AppBundle\Entity\Depot $depot)
    {
        $this->depot->removeElement($depot);
    }

    /**
     * Get depot
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDepot()
    {
        return $this->depot;
    }
}
