<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lpsa\CoreBundle\Entity\FileInterface;

/**
 * NarrationPj
 *
 * @ORM\Table(name="evenement_enquete_pj")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\EvenementEnquetePjRepository")
 */
class EvenementEnquetePj extends FileBase implements FileInterface
{       
    /**
    * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\EvenementEnquete", inversedBy="evenementEnquetePJs")
    * @ORM\JoinColumn(name="evenement_enquete_id", referencedColumnName="id", onDelete="CASCADE")
    */
    private $evenementEnquete;  

    /**
     * Set evenementEnquete
     *
     * @param \Lpsa\AppBundle\Entity\EvenementEnquete $evenementEnquete
     *
     * @return EvenementEnquetePj
     */
    public function setEvenementEnquete(\Lpsa\AppBundle\Entity\EvenementEnquete $evenementEnquete = null)
    {
        $this->evenementEnquete = $evenementEnquete;

        return $this;
    }

    /**
     * Get evenementEnquete
     *
     * @return \Lpsa\AppBundle\Entity\EvenementEnquete
     */
    public function getEvenementEnquete()
    {
        return $this->evenementEnquete;
    }
    
    public function getRootDir(){
        return 'evenement/evenementenquete/'.$this->getEvenementEnquete()->getEvenement()->getId()."/";
    }
}
