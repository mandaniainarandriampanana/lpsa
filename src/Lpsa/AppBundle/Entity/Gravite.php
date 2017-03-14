<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Gravite
 *
 * @ORM\Table(name="gravite")
 * @UniqueEntity(fields={"valeur"})
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\GraviteRepository")
 */
class Gravite extends Base
{
    /**
     * @var string
     *
     * @ORM\Column(name="valeur", type="string", length=255, unique=true)
     */
    private $valeur;

    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\Environnement", mappedBy="gravite")
     */
    private $environnements;
    
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\Corporel", mappedBy="gravite")
     */
    private $corporels;
    
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\Materiel", mappedBy="gravite")
     */
    private $materiels;
    
     /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\ImpactMediatique", mappedBy="gravite")
     */
    private $impactMediatiques;
    
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\ImpactClient", mappedBy="gravite")
     */
    private $impactClients;
    
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\Dysfonctionnement", mappedBy="gravite")
     */
    private $dysfonctionnements;
    
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\Evenement", mappedBy="gravite")
     */
    private $evenements;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->impactMediatiques = new \Doctrine\Common\Collections\ArrayCollection();
        $this->impactClients = new \Doctrine\Common\Collections\ArrayCollection();
        $this->environnements = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dysfonctionnements = new \Doctrine\Common\Collections\ArrayCollection();
        $this->corporels = new \Doctrine\Common\Collections\ArrayCollection();
        $this->materiels = new \Doctrine\Common\Collections\ArrayCollection();
        $this->evenements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set valeur
     *
     * @param string $valeur
     *
     * @return Gravite
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * Get valeur
     *
     * @return string
     */
    public function getValeur()
    {
        return $this->valeur;
    }
    /**
     * Add impactMediatique
     *
     * @param \Lpsa\AppBundle\Entity\ImpactMediatique $impactMediatique
     *
     * @return Gravite
     */
    public function addImpactMediatique(\Lpsa\AppBundle\Entity\ImpactMediatique $impactMediatique)
    {
        $this->impactMediatiques[] = $impactMediatique;

        return $this;
    }

    /**
     * Remove impactMediatique
     *
     * @param \Lpsa\AppBundle\Entity\ImpactMediatique $impactMediatique
     */
    public function removeImpactMediatique(\Lpsa\AppBundle\Entity\ImpactMediatique $impactMediatique)
    {
        $this->impactMediatiques->removeElement($impactMediatique);
    }

    /**
     * Get impactMediatiques
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImpactMediatiques()
    {
        return $this->impactMediatiques;
    }
    /**
     * Add impactClients
     *
     * @param \Lpsa\AppBundle\Entity\ImpactClient $impactClients
     * @return Gravite
     */
    public function addImpactClient(\Lpsa\AppBundle\Entity\ImpactClient $impactClients)
    {
        $this->impactClients[] = $impactClients;
    }
    
    /**
     * Remove impactClients
     *
     * @param \Lpsa\AppBundle\Entity\ImpactClient $impactClients
     */
    public function removeImpactClient(\Lpsa\AppBundle\Entity\ImpactClient $impactClients)
    {
        $this->impactClients->removeElement($impactClients);
    }

    /**
     * Get impactClients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImpactClients()
    {
        return $this->impactClients;
    }
    /**
     * Add environnement
     *
     * @param \Lpsa\AppBundle\Entity\Environnement $environnement
     *
     * @return Gravite
     */
    public function addEnvironnement(\Lpsa\AppBundle\Entity\Environnement $environnement)
    {
        $this->environnements[] = $environnement;

        return $this;
    }

    /**
     * Remove environnement
     *
     * @param \Lpsa\AppBundle\Entity\Environnement $environnement
     */
    public function removeEnvironnement(\Lpsa\AppBundle\Entity\Environnement $environnement)
    {
        $this->environnements->removeElement($environnement);
    }

    /**
     * Get environnements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnvironnements()
    {
        return $this->environnements;
    }

    /**
     * Add dysfonctionnement
     *
     * @param \Lpsa\AppBundle\Entity\Dysfonctionnement $dysfonctionnement
     *
     * @return Gravite
     */
    public function addDysfonctionnement(\Lpsa\AppBundle\Entity\Dysfonctionnement $dysfonctionnement)
    {
        $this->dysfonctionnements[] = $dysfonctionnement;

        return $this;
    }

    /**
     * Remove dysfonctionnement
     *
     * @param \Lpsa\AppBundle\Entity\Dysfonctionnement $dysfonctionnement
     */
    public function removeDysfonctionnement(\Lpsa\AppBundle\Entity\Dysfonctionnement $dysfonctionnement)
    {
        $this->dysfonctionnements->removeElement($dysfonctionnement);
    }

    /**
     * Get dysfonctionnements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDysfonctionnements()
    {
        return $this->dysfonctionnements;
    }

    /**
     * Add corporel
     *
     * @param \Lpsa\AppBundle\Entity\Corporel $corporel
     *
     * @return Gravite
     */
    public function addCorporel(\Lpsa\AppBundle\Entity\Corporel $corporel)
    {
        $this->corporels[] = $corporel;

        return $this;
    }

    /**
     * Remove corporel
     *
     * @param \Lpsa\AppBundle\Entity\Corporel $corporel
     */
    public function removeCorporel(\Lpsa\AppBundle\Entity\Corporel $corporel)
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

    /**
     * Add materiel
     *
     * @param \Lpsa\AppBundle\Entity\Materiel $materiel
     *
     * @return Gravite
     */
    public function addMateriel(\Lpsa\AppBundle\Entity\Materiel $materiel)
    {
        $this->materiels[] = $materiel;

        return $this;
    }

    /**
     * Remove materiel
     *
     * @param \Lpsa\AppBundle\Entity\Materiel $materiel
     */
    public function removeMateriel(\Lpsa\AppBundle\Entity\Materiel $materiel)
    {
        $this->materiels->removeElement($materiel);
    }

    /**
     * Get materiels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMateriels()
    {
        return $this->materiels;
    }

    /**
     * Add evenement
     *
     * @param \Lpsa\AppBundle\Entity\Evenement $evenement
     *
     * @return Gravite
     */
    public function addEvenement(\Lpsa\AppBundle\Entity\Evenement $evenement)
    {
        $this->evenements[] = $evenement;

        return $this;
    }

    /**
     * Remove evenement
     *
     * @param \Lpsa\AppBundle\Entity\Evenement $evenement
     */
    public function removeEvenement(\Lpsa\AppBundle\Entity\Evenement $evenement)
    {
        $this->evenements->removeElement($evenement);
    }

    /**
     * Get evenements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvenements()
    {
        return $this->evenements;
    }
}
