<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeCorporel
 *
 * @ORM\Table(name="type_corporel")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\TypeCorporelRepository")
 */
class TypeCorporel extends Base
{
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\Corporel", mappedBy="typeCorporel")
     */
    private $corporels;
    
    public function __construct(){
        $this->corporels = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add corporel
     *
     * @param \Lpsa\AppBundle\Entity\TypeCorporel $corporel
     *
     * @return TypeCorporel
     */
    public function addCorporel(\Lpsa\AppBundle\Entity\TypeCorporel $corporel)
    {
        $this->corporels[] = $corporel;

        return $this;
    }

    /**
     * Remove corporel
     *
     * @param \Lpsa\AppBundle\Entity\TypeCorporel $corporel
     */
    public function removeCorporel(\Lpsa\AppBundle\Entity\TypeCorporel $corporel)
    {
        $this->corporels->removeElement($corporel);
    }

    /**
     * Get corporels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCorporels()
    {
        return $this->corporels;
    }
}
