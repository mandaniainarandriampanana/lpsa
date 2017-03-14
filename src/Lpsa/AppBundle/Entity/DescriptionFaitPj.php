<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lpsa\CoreBundle\Entity\FileInterface;

/**
 * DescriptionFaitPj
 *
 * @ORM\Table(name="description_fait_pj")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\DescriptionFaitPjRepository")
 */
class DescriptionFaitPj extends FileBase implements FileInterface
{       
    /**
    * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Evenement", inversedBy="descriptionFaitPJs")
    * @ORM\JoinColumn(name="evenement_id", referencedColumnName="id", onDelete="CASCADE")
    */
    private $evenement;    

    
    /**
     * Set evenement
     *
     * @param \Lpsa\AppBundle\Entity\Evenement $evenement
     *
     * @return DescriptionFaitPj
     */
    public function setEvenement(\Lpsa\AppBundle\Entity\Evenement $evenement = null)
    {
        $this->evenement = $evenement;

        return $this;
    }

    /**
     * Get evenement
     *
     * @return \Lpsa\AppBundle\Entity\Evenement
     */
    public function getEvenement()
    {
        return $this->evenement;
    }

    public function getRootDir(){
        return 'evenement/descriptionfait/'.$this->getEvenement()->getId()."/";
    }
}
