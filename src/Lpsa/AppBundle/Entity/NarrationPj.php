<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lpsa\CoreBundle\Entity\FileInterface;

/**
 * NarrationPj
 *
 * @ORM\Table(name="narration_pj")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\NarrationPjRepository")
 */
class NarrationPj extends FileBase implements FileInterface
{       
    /**
    * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Evenement", inversedBy="narrationPJs")
    * @ORM\JoinColumn(name="evenement_id", referencedColumnName="id", onDelete="CASCADE")
    */
    private $evenement;    

    
    /**
     * Set evenement
     *
     * @param \Lpsa\AppBundle\Entity\Evenement $evenement
     *
     * @return NarrationPj
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
        return 'evenement/narration/'.$this->getEvenement()->getId()."/";
    }
}
