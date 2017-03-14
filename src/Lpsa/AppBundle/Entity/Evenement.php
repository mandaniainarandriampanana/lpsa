<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\EvenementRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var int
     *
     * @ORM\Column(name="nbre_lpsa", type="integer", nullable=true, options={"default":0})
     * @Assert\Type("integer")
     */
    protected $nbreLpsa;

    /**
     * @ORM\OneToOne(targetEntity="Lpsa\AppBundle\Entity\Paq3se", mappedBy="evenement",cascade={"persist", "remove"})
     */
    private $paq3se;
    
    /**
     * @var int
     *
     * @ORM\Column(name="nbre_contracte", type="integer", nullable=true, options={"default":0})
     * @Assert\Type("integer")
     */
    protected $nbreContracte;
    
    /**
     * @var int
     *
     * @ORM\Column(name="nbre_tiers", type="integer", nullable=true, options={"default":0})
     * @Assert\Type("integer")
     */
    protected $nbreTiers;    
    
    /**
     * @var float
     *
     * @ORM\Column(name="nbre_environnement", type="decimal", scale=5, nullable=true, options={"default":0})
     * @Assert\Type("numeric")
     */
    protected $nbreEnvironnement;
    
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\UserBundle\Entity\User", inversedBy="evenements")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;
    
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\UserBundle\Entity\User", inversedBy="declarantEvenements")
     * @ORM\JoinColumn(name="user_declarant_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotBlank()
     */
    private $userDeclarant;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_emission", type="date", nullable=false)
     * @Assert\NotBlank()
     */
    private $dateEmission;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_des_faits", type="date", nullable=false)
     * @Assert\NotBlank()
     */
    private $dateDesFaits;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_action", type="date", nullable=true)
     */
    private $dateAction;
        
    /**
     * @var EvenementCategorie
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\EvenementCategorie", inversedBy="evenements")
     * @ORM\JoinColumn(name="categorie_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotBlank()
     */
    private $categorie;
    
    /**
     * @var Environnement
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Environnement", inversedBy="evenements")
     * @ORM\JoinColumn(name="environnement_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $environnement;

    /**
     * @var TypeAccident
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\TypeAccident")
     * @ORM\JoinColumn(name="type_accident_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $typeAccident;

    /**
     * @var TypeSituationDangereuse
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\TypeSituationDangereuse")
     * @ORM\JoinColumn(name="type_situation_dangereuse_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $typeSituationDangereuse;
    
    /**
     * @var Dysfonctionnement
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Dysfonctionnement", inversedBy="evenements")
     * @ORM\JoinColumn(name="dysfonctionnement_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $dysfonctionnement;
    
    /**
     * @var Depot
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Depot", inversedBy="evenements")
     * @ORM\JoinColumn(name="depot_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotBlank()
     */
    private $depot;
    /**
     * @var ImpactClient
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\ImpactClient", inversedBy="evenements")
     * @ORM\JoinColumn(name="impact_client_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $impactClient;
    
    /**
     * @var ImpactMediatique
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\ImpactMediatique", inversedBy="evenements")
     * @ORM\JoinColumn(name="impact_mediatique_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $impactMediatique;
    
    /**
     * @var EvenementStatut
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\EvenementStatut", inversedBy="evenements")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $evenementStatut;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_cloture", type="date", nullable=true)
     */
    private $dateCloture;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_update", type="date", nullable=true)
     */
    private $dateUpdate;

    /**
     * @ORM\OneToOne(targetEntity="Lpsa\AppBundle\Entity\EvenementEnquete", mappedBy="evenement",cascade={"persist"})
     */
    private $evenementEnquete;
    
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\EvenementActionProgres", mappedBy="evenement",cascade={"persist"})
     */
    private $evenementActionProgres;
    
    /**
     * @var text
     *
     * @ORM\Column(name="description_fait", type="text", nullable=true)
     */
    private $descriptionFait;
    
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\DescriptionFaitPj", mappedBy="evenement",cascade={"persist"})
     */
    private $descriptionFaitPJs;
    
    /**
     * @var text
     *
     * @ORM\Column(name="narration", type="text", nullable=true)
     */
    private $narration;
    
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\NarrationPj", mappedBy="evenement",cascade={"persist"})
     */
    private $narrationPJs;
    
    /**
     * @var Materiel
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Materiel", inversedBy="evenements")
     * @ORM\JoinColumn(name="materiel_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $materiel;
    
    /**
     * @var Corporel
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Corporel", inversedBy="evenements")
     * @ORM\JoinColumn(name="corporel_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $corporel;
    
    /**
    * @ORM\ManyToOne(targetEntity="Gravite", inversedBy="evenements")
    * @ORM\JoinColumn(name="gravite_id", referencedColumnName="id", onDelete="CASCADE")
    */
    private  $gravite;
   
    /**
     * @var string
     *
     * @ORM\Column(name="numero_enregistrement", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $numeroEnregistrement;  
    
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\EvenementHistorique", mappedBy="evenement")
     */
    private $evenementHitoriques;

    /**
     *
     * @var type  boolean
     * @ORM\Column(name="is_paqssse", type="boolean",nullable=false)
     */
    private $isPaqssse;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->evenementActionProgres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->narrationPJs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->descriptionFaitPJs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->evenementHitoriques = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set user
     *
     * @param \Lpsa\UserBundle\Entity\User $user
     *
     * @return Evenement
     */
    public function setUser(\Lpsa\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Lpsa\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set categorie
     *
     * @param \Lpsa\AppBundle\Entity\EvenementCategorie $categorie
     *
     * @return Evenement
     */
    public function setCategorie(\Lpsa\AppBundle\Entity\EvenementCategorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \Lpsa\AppBundle\Entity\EvenementCategorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set depot
     *
     * @param \Lpsa\AppBundle\Entity\Depot $depot
     *
     * @return Evenement
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

    /**
     * Set impactClient
     *
     * @param \Lpsa\AppBundle\Entity\ImpactClient $impactClient
     *
     * @return Evenement
     */
    public function setImpactClient(\Lpsa\AppBundle\Entity\ImpactClient $impactClient = null)
    {
        $this->impactClient = $impactClient;

        return $this;
    }

    /**
     * Get impactClient
     *
     * @return \Lpsa\AppBundle\Entity\ImpactClient
     */
    public function getImpactClient()
    {
        return $this->impactClient;
    }

    /**
     * Set impactMediatique
     *
     * @param \Lpsa\AppBundle\Entity\ImpactMediatique $impactMediatique
     *
     * @return Evenement
     */
    public function setImpactMediatique(\Lpsa\AppBundle\Entity\ImpactMediatique $impactMediatique = null)
    {
        $this->impactMediatique = $impactMediatique;

        return $this;
    }

    /**
     * Get impactMediatique
     *
     * @return \Lpsa\AppBundle\Entity\ImpactMediatique
     */
    public function getImpactMediatique()
    {
        return $this->impactMediatique;
    }

    /**
     * Set evenementStatut
     *
     * @param \Lpsa\AppBundle\Entity\EvenementStatut $evenementStatut
     *
     * @return Evenement
     */
    public function setEvenementStatut(\Lpsa\AppBundle\Entity\EvenementStatut $evenementStatut = null)
    {
        $this->evenementStatut = $evenementStatut;
        //if closed
        if($evenementStatut && ($evenementStatut->getId() === 2)){
            $this->setDateCloture(new \DateTime('now'));
        } else {
            $this->setDateCloture(null);
        }
        return $this;
    }

    /**
     * Get evenementStatut
     *
     * @return \Lpsa\AppBundle\Entity\EvenementStatut
     */
    public function getEvenementStatut()
    {
        return $this->evenementStatut;
    }

    /**
     * Add evenementActionProgre
     *
     * @param \Lpsa\AppBundle\Entity\EvenementActionProgres $evenementActionProgre
     *
     * @return Evenement
     */
    public function addEvenementActionProgre(\Lpsa\AppBundle\Entity\EvenementActionProgres $evenementActionProgre)
    {
        $this->evenementActionProgres[] = $evenementActionProgre;

        return $this;
    }

    /**
     * Remove evenementActionProgre
     *
     * @param \Lpsa\AppBundle\Entity\EvenementActionProgres $evenementActionProgre
     */
    public function removeEvenementActionProgre(\Lpsa\AppBundle\Entity\EvenementActionProgres $evenementActionProgre)
    {
        $this->evenementActionProgres->removeElement($evenementActionProgre);
    }

    /**
     * Get evenementActionProgres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvenementActionProgres()
    {
        return $this->evenementActionProgres;
    }

    /**
     * Set evenementEnquete
     *
     * @param \Lpsa\AppBundle\Entity\EvenementEnquete $evenementEnquete
     *
     * @return Evenement
     */
    public function setEvenementEnquete(\Lpsa\AppBundle\Entity\EvenementEnquete $evenementEnquete = null)
    {
        $evenementEnquete->setEvenement($this);
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

    /**
     * Set dateEmission
     *
     * @param \DateTime $dateEmission
     *
     * @return Evenement
     */
    public function setDateEmission($dateEmission)
    {
        $this->dateEmission = $dateEmission;

        return $this;
    }

    /**
     * Get dateEmission
     *
     * @return \DateTime
     */
    public function getDateEmission()
    {
        return $this->dateEmission;
    }

    /**
     * Set dateDesFaits
     *
     * @param \DateTime $dateDesFaits
     *
     * @return Evenement
     */
    public function setDateDesFaits($dateDesFaits)
    {
        $this->dateDesFaits = $dateDesFaits;

        return $this;
    }

    /**
     * Get dateDesFaits
     *
     * @return \DateTime
     */
    public function getDateDesFaits()
    {
        return $this->dateDesFaits;
    }

    /**
     * Set dateAction
     *
     * @param \DateTime $dateAction
     *
     * @return Evenement
     */
    public function setDateAction($dateAction)
    {
        $this->dateAction = $dateAction;

        return $this;
    }

    /**
     * Get dateAction
     *
     * @return \DateTime
     */
    public function getDateAction()
    {
        return $this->dateAction;
    }

    /**
     * Set dateCloture
     *
     * @param \DateTime $dateCloture
     *
     * @return Evenement
     */
    public function setDateCloture($dateCloture)
    {
        $this->dateCloture = $dateCloture;

        return $this;
    }

    /**
     * Get dateCloture
     *
     * @return \DateTime
     */
    public function getDateCloture()
    {
        return $this->dateCloture;
    }

    /**
     * Set userDeclarant
     *
     * @param \Lpsa\UserBundle\Entity\User $userDeclarant
     *
     * @return Evenement
     */
    public function setUserDeclarant(\Lpsa\UserBundle\Entity\User $userDeclarant = null)
    {
        $this->userDeclarant = $userDeclarant;

        return $this;
    }

    /**
     * Get userDeclarant
     *
     * @return \Lpsa\UserBundle\Entity\User
     */
    public function getUserDeclarant()
    {
        return $this->userDeclarant;
    }

    /**
     * Set environnement
     *
     * @param \Lpsa\AppBundle\Entity\Environnement $environnement
     *
     * @return Evenement
     */
    public function setEnvironnement(\Lpsa\AppBundle\Entity\Environnement $environnement = null)
    {
        $this->environnement = $environnement;

        return $this;
    }

    /**
     * Get environnement
     *
     * @return \Lpsa\AppBundle\Entity\Environnement
     */
    public function getEnvironnement()
    {
        return $this->environnement;
    }

    /**
     * Set dysfonctionnement
     *
     * @param \Lpsa\AppBundle\Entity\Dysfonctionnement $dysfonctionnement
     *
     * @return Evenement
     */
    public function setDysfonctionnement(\Lpsa\AppBundle\Entity\Dysfonctionnement $dysfonctionnement = null)
    {
        $this->dysfonctionnement = $dysfonctionnement;

        return $this;
    }

    /**
     * Get dysfonctionnement
     *
     * @return \Lpsa\AppBundle\Entity\Dysfonctionnement
     */
    public function getDysfonctionnement()
    {
        return $this->dysfonctionnement;
    }

    /**
     * Set descriptionFait
     *
     * @param string $descriptionFait
     *
     * @return Evenement
     */
    public function setDescriptionFait($descriptionFait)
    {
        $this->descriptionFait = $descriptionFait;

        return $this;
    }

    /**
     * Get descriptionFait
     *
     * @return string
     */
    public function getDescriptionFait()
    {
        return $this->descriptionFait;
    }
    
    /**
     * Set narration
     *
     * @param string $narration
     *
     * @return Evenement
     */
    public function setNarration($narration)
    {
        $this->narration = $narration;

        return $this;
    }

    /**
     * Get narration
     *
     * @return string
     */
    public function getNarration()
    {
        return $this->narration;
    }
    
    public function setDescriptionFaitDirectory($descriptionFaitDir){
        $this->descriptionFaitDir = $descriptionFaitDir;
    }
    /**
     * Get upload descriptionFait directory
     * 
     * @return string
     */
    public function getUploadDescriptionFaitDirectory(){
        return $this->descriptionFaitDir;
    }
    
    /**
     * Get upload narration directory
     * 
     * @return string
     */
    public function getUploadNarrationDirectory(){
        return $this->narrationDir;
    }

    /**
     * Set materiel
     *
     * @param \Lpsa\AppBundle\Entity\Materiel $materiel
     *
     * @return Evenement
     */
    public function setMateriel(\Lpsa\AppBundle\Entity\Materiel $materiel = null)
    {
        $this->materiel = $materiel;

        return $this;
    }

    /**
     * Get materiel
     *
     * @return \Lpsa\AppBundle\Entity\Materiel
     */
    public function getMateriel()
    {
        return $this->materiel;
    }

    /**
     * Set corporel
     *
     * @param \Lpsa\AppBundle\Entity\Corporel $corporel
     *
     * @return Evenement
     */
    public function setCorporel(\Lpsa\AppBundle\Entity\Corporel $corporel = null)
    {
        $this->corporel = $corporel;

        return $this;
    }

    /**
     * Get corporel
     *
     * @return \Lpsa\AppBundle\Entity\Corporel
     */
    public function getCorporel()
    {
        return $this->corporel;
    }

    /**
     * Set nbreEnvironnement
     *
     * @param float $nbreEnvironnement
     *
     * @return Evenement
     */
    public function setNbreEnvironnement($nbreEnvironnement)
    {
        $this->nbreEnvironnement = $nbreEnvironnement;

        return $this;
    }

    /**
     * Get nbreEnvironnement
     *
     * @return float
     */
    public function getNbreEnvironnement()
    {
        return $this->nbreEnvironnement;
    }

    /**
     * Set numeroEnregistrement
     *
     * @param string $numeroEnregistrement
     *
     * @return Evenement
     */
    public function setNumeroEnregistrement($numeroEnregistrement)
    {
        $this->numeroEnregistrement = $numeroEnregistrement;

        return $this;
    }

    /**
     * Get numeroEnregistrement
     *
     * @return string
     */
    public function getNumeroEnregistrement()
    {
        return $this->numeroEnregistrement;
    }

    /**
     * Set nbreLpsa
     *
     * @param integer $nbreLpsa
     *
     * @return Evenement
     */
    public function setNbreLpsa($nbreLpsa)
    {
        $this->nbreLpsa = $nbreLpsa;

        return $this;
    }

    /**
     * Get nbreLpsa
     *
     * @return integer
     */
    public function getNbreLpsa()
    {
        return $this->nbreLpsa;
    }

    /**
     * Set nbreContracte
     *
     * @param integer $nbreContracte
     *
     * @return Evenement
     */
    public function setNbreContracte($nbreContracte)
    {
        $this->nbreContracte = $nbreContracte;

        return $this;
    }

    /**
     * Get nbreContracte
     *
     * @return integer
     */
    public function getNbreContracte()
    {
        return $this->nbreContracte;
    }

    /**
     * Set nbreTiers
     *
     * @param integer $nbreTiers
     *
     * @return Evenement
     */
    public function setNbreTiers($nbreTiers)
    {
        $this->nbreTiers = $nbreTiers;

        return $this;
    }

    /**
     * Get nbreTiers
     *
     * @return integer
     */
    public function getNbreTiers()
    {
        return $this->nbreTiers;
    }

    /**
     * Set gravite
     *
     * @param \Lpsa\AppBundle\Entity\Gravite $gravite
     *
     * @return Evenement
     */
    public function setGravite(\Lpsa\AppBundle\Entity\Gravite $gravite = null)
    {
        $this->gravite = $gravite;

        return $this;
    }

    /**
     * Get gravite
     *
     * @return \Lpsa\AppBundle\Entity\Gravite
     */
    public function getGravite()
    {
        return $this->gravite;
    }

    /**
     * Add narrationPJ
     *
     * @param \Lpsa\AppBundle\Entity\NarrationPj $narrationPJ
     *
     * @return Evenement
     */
    public function addNarrationPJ(\Lpsa\AppBundle\Entity\NarrationPj $narrationPJ)
    {
        $narrationPJ->setEvenement($this);
        $this->narrationPJs[] = $narrationPJ;

        return $this;
    }

    /**
     * Remove narrationPJ
     *
     * @param \Lpsa\AppBundle\Entity\NarrationPj $narrationPJ
     */
    public function removeNarrationPJ(\Lpsa\AppBundle\Entity\NarrationPj $narrationPJ)
    {
        $this->narrationPJs->removeElement($narrationPJ);
    }

    /**
     * Get narrationPJs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNarrationPJs()
    {
        return $this->narrationPJs;
    }

    /**
     * Add descriptionFaitPJ
     *
     * @param \Lpsa\AppBundle\Entity\DescriptionFaitPj $descriptionFaitPJ
     *
     * @return Evenement
     */
    public function addDescriptionFaitPJ(\Lpsa\AppBundle\Entity\DescriptionFaitPj $descriptionFaitPJ)
    {
        $descriptionFaitPJ->setEvenement($this);
        $this->descriptionFaitPJs[] = $descriptionFaitPJ;

        return $this;
    }

    /**
     * Remove descriptionFaitPJ
     *
     * @param \Lpsa\AppBundle\Entity\DescriptionFaitPj $descriptionFaitPJ
     */
    public function removeDescriptionFaitPJ(\Lpsa\AppBundle\Entity\DescriptionFaitPj $descriptionFaitPJ)
    {
        $this->descriptionFaitPJs->removeElement($descriptionFaitPJ);
    }

    /**
     * Get descriptionFaitPJs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDescriptionFaitPJs()
    {
        return $this->descriptionFaitPJs;
    }

    /**
     * Add evenementHitorique
     *
     * @param \Lpsa\AppBundle\Entity\EvenementHistorique $evenementHitorique
     *
     * @return Evenement
     */
    public function addEvenementHitorique(\Lpsa\AppBundle\Entity\EvenementHistorique $evenementHitorique)
    {
        $this->evenementHitoriques[] = $evenementHitorique;

        return $this;
    }

    /**
     * Remove evenementHitorique
     *
     * @param \Lpsa\AppBundle\Entity\EvenementHistorique $evenementHitorique
     */
    public function removeEvenementHitorique(\Lpsa\AppBundle\Entity\EvenementHistorique $evenementHitorique)
    {
        $this->evenementHitoriques->removeElement($evenementHitorique);
    }

    /**
     * Get evenementHitoriques
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvenementHitoriques()
    {
        return $this->evenementHitoriques;
    }

    /**
     * Set dateUpdate
     *
     * @param \DateTime $dateUpdate
     *
     * @return Evenement
     */
    public function setDateUpdate($dateUpdate)
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    /**
     * Get dateUpdate
     *
     * @return \DateTime
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }
    /**
     * @ORM\PreUpdate()
     */
    public function filDateUpdate(){
        $this->dateUpdate = new \DateTime();
    }

    /**
     * Set typeAccident
     *
     * @param \Lpsa\AppBundle\Entity\TypeAccident $typeAccident
     *
     * @return Evenement
     */
    public function setTypeAccident(\Lpsa\AppBundle\Entity\TypeAccident $typeAccident = null)
    {
        $this->typeAccident = $typeAccident;

        return $this;
    }

    /**
     * Get typeAccident
     *
     * @return \Lpsa\AppBundle\Entity\TypeAccident
     */
    public function getTypeAccident()
    {
        return $this->typeAccident;
    }

    /**
     * Set typeSituationDangereuse
     *
     * @param \Lpsa\AppBundle\Entity\TypeSituationDangereuse $typeSituationDangereuse
     *
     * @return Evenement
     */
    public function setTypeSituationDangereuse(\Lpsa\AppBundle\Entity\TypeSituationDangereuse $typeSituationDangereuse = null)
    {
        $this->typeSituationDangereuse = $typeSituationDangereuse;

        return $this;
    }

    /**
     * Get typeSituationDangereuse
     *
     * @return \Lpsa\AppBundle\Entity\TypeSituationDangereuse
     */
    public function getTypeSituationDangereuse()
    {
        return $this->typeSituationDangereuse;
    }

    /**
     * Set isPaqssse
     *
     * @param boolean $isPaqssse
     *
     * @return Evenement
     */
    public function setIsPaqssse($isPaqssse)
    {
        $this->isPaqssse = $isPaqssse;

        return $this;
    }

    /**
     * Get isPaqssse
     *
     * @return boolean
     */
    public function getIsPaqssse()
    {
        return $this->isPaqssse;
    }

    /**
     * Set paq3se
     *
     * @param \Lpsa\AppBundle\Entity\Paq3se $paq3se
     *
     * @return Evenement
     */
    public function setPaq3se(\Lpsa\AppBundle\Entity\Paq3se $paq3se = null)
    {
        $this->paq3se = $paq3se;

        return $this;
    }

    /**
     * Get paq3se
     *
     * @return \Lpsa\AppBundle\Entity\Paq3se
     */
    public function getPaq3se()
    {
        return $this->paq3se;
    }
}
