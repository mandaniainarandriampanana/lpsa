<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HeureTravailCategorie
 *
 * @ORM\Table(name="heure_travail_categorie")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\HeureTravailCategorieRepository")
 */
class HeureTravailCategorie extends Base
{
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\HeureTravail", mappedBy="heureTravailCategorie")
     */
    private $heureTravails;
    
    
    public function __construct()
    {
        $this->heureTravails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add heureTravail
     *
     * @param \Lpsa\AppBundle\Entity\HeureTravail $heureTravail
     *
     * @return HeureTravailCategorie
     */
    public function addHeureTravail(\Lpsa\AppBundle\Entity\HeureTravail $heureTravail)
    {
        $this->heureTravails[] = $heureTravail;

        return $this;
    }

    /**
     * Remove heureTravail
     *
     * @param \Lpsa\AppBundle\Entity\HeureTravail $heureTravail
     */
    public function removeHeureTravail(\Lpsa\AppBundle\Entity\HeureTravail $heureTravail)
    {
        $this->heureTravails->removeElement($heureTravail);
    }

    /**
     * Get heureTravails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHeureTravails()
    {
        return $this->heureTravails;
    }
}
