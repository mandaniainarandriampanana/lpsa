<?php

namespace Lpsa\AppBundle\Form\Handler\Evenement;

use Lpsa\AppBundle\Entity\Evenement;
use Lpsa\AppBundle\Entity\EvenementActionProgres;
use Lpsa\AppBundle\Entity\Manager\Interfaces\EvenementActionProgresManagerInterface;
use Lpsa\AppBundle\Service\RepositoryNumberGenerate;
use Lpsa\AppBundle\Entity\Observable\EventObservable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Lpsa\AppBundle\Entity\Paq3se;

class EvenementFormHandler {
    
    /**
     * @var string 
     */
    private $message = "";
    
    /**
     * @var AbstractEvenementFormHandlerStrategy
     */
    protected $evenementFormHandlerStrategy;
    
    /**
     * @var AbstractEvenementFormHandlerStrategy
     */
    protected $newEvenementFormHandlerStrategy;
    
    /**
     * @var AbstractEvenementFormHandlerStrategy
     */
    protected $updateEvenementFormHandlerStrategy;
    
    /**
     * @var EvenementActionProgresManagerInterface 
     */
    protected $evenementActionProgresManager;

    /**
     *
     * @var RepositoryNumberGenerate 
     */
    protected $repositoryNumberGenerate;
    
    /**
     *
     * @var Container 
     */
    protected $container;
    
    /**
     *
     * @var ObjectManager 
     */
    protected $em;
    
    protected $eventObservable;

    public function __construct(EvenementActionProgresManagerInterface $evenementActionProgresManager,RepositoryNumberGenerate $repositoryNumberGenerate, Container $container,ObjectManager $em,EventObservable $eventObservable) {
        $this->evenementActionProgresManager = $evenementActionProgresManager;
        $this->repositoryNumberGenerate = $repositoryNumberGenerate;
        $this->container = $container;
        $this->em = $em;
        $this->eventObservable = $eventObservable;
    }
    
    public function setNewEvenementFormHandlerStrategy(AbstractEvenementFormHandlerStrategy $evenementFormHandlerStrategy) {
        $this->newEvenementFormHandlerStrategy = $evenementFormHandlerStrategy;
    }
    
    public function setUpdateEvenementFormHandlerStrategy(AbstractEvenementFormHandlerStrategy $evenementFormHandlerStrategy) {
        $this->updateEvenementFormHandlerStrategy = $evenementFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param Evenement $evenement
     * @return Evenement
     */
    public function processForm(Evenement $evenement = null){
        if (is_null($evenement)){ 
            $evenement = new Evenement();
            $this->evenementFormHandlerStrategy = $this->newEvenementFormHandlerStrategy;
        } else {
            $this->evenementFormHandlerStrategy = $this->updateEvenementFormHandlerStrategy;
        }
        return $evenement;
    }
    
    public function handleForm(FormInterface $form, Evenement $evenement, Request $request)
    {
        if (
            (null === $evenement->getId() && $request->isMethod('POST'))
            || (null !== $evenement->getId() && $request->isMethod('PUT'))
        ) {   
            $serviceManagerListener = $this->container->get('app.listener.servicemanager');
            $serviceManagerListener->setActionProgress($this->copyArrayCollection($evenement->getEvenementActionProgres()));//store old data, to be compare in listener
            $originalNarrationPJs = new ArrayCollection();
            foreach ($evenement->getNarrationPJs() as $pj) {
                $originalNarrationPJs->add($pj);
            }
            $originalDescriptionPJs = new ArrayCollection();
            foreach ($evenement->getDescriptionFaitPJs() as $pj) {
                $originalDescriptionPJs->add($pj);
            }
            $originalEnquetePJs = new ArrayCollection();
            $originalEvenementEnquete = $evenement->getEvenementEnquete();
            if($originalEvenementEnquete){
                foreach ($originalEvenementEnquete->getEvenementEnquetePJs() as $pj) {
                    $originalEnquetePJs->add($pj);
                }                
            }
            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
            //prevent request mapping error for attachment even if js already prevent this
            $this->cleanForAttachmentError($evenement);
            
            foreach($evenement->getEvenementActionProgres() as $evtActionProgres){
                if($this->checkValidEvtActionProgres($evtActionProgres)){
                    $actionStatus = $evtActionProgres->getEvenementActionProgresStatus();
                    if(!$actionStatus){
                        //new
                        $actionStatus = $this->em->getRepository('LpsaAppBundle:EvenementActionProgresStatus')->findOneById(1);
                        $evtActionProgres->setEvenementActionProgresStatus($actionStatus);
                    }
                    $evtActionProgres->setEvenement($evenement);                    
                } else {
                    $evenement->removeEvenementActionProgre($evtActionProgres);
                    $this->evenementActionProgresManager->remove($evtActionProgres);
                }
            }
            
            foreach ($originalNarrationPJs as $narrationPj) {
                if (false === $evenement->getNarrationPJs()->contains($narrationPj)) {
                    $evenement->getNarrationPJs()->removeElement($narrationPj);                    
                    $this->em->remove($narrationPj);
                }
            }
            
            foreach ($originalDescriptionPJs as $descriptionPj) {
                if (false === $evenement->getDescriptionFaitPJs()->contains($descriptionPj)) {
                    $evenement->getDescriptionFaitPJs()->removeElement($descriptionPj);                    
                    $this->em->remove($descriptionPj);
                }
            }
            
            foreach ($originalEnquetePJs as $enquetePj) {
                if (false === $evenement->getEvenementEnquete()->getEvenementEnquetePJs()->contains($enquetePj)) {
                    $evenement->getEvenementEnquete()->getEvenementEnquetePJs()->removeElement($enquetePj);                    
                    $this->em->remove($enquetePj);
                }
            }
            
            //verify NumeroEnregistrement before saved
            $number = $this->repositoryNumberGenerate->checkNumber($evenement->getNumeroEnregistrement(),$evenement->getDepot(),$evenement->getId());
            $evenement->setNumeroEnregistrement($number);
            //force update relationship
            $evenementEnquete = $evenement->getEvenementEnquete();
            if($evenementEnquete){
                $evenementEnquete->setEvenement($evenement);                
            }
            //paqssse
            $paqssse = $evenement->getPaq3se();
            if($paqssse){
                $paqssse->setEvenement($evenement);
            }

            $isPaq3se = $evenement->getIsPaqssse();
            if(!$isPaq3se){
                if($paqssse){
                    //check if required fields is empty before deleting
                    if(empty($paqssse->getFrequence()) && empty($paqssse->getRealisation()) && empty($paqssse->getAnomalieConstate())){
                        $evenement->setPaq3se(null);
                        $paqssse->setEvenement(null);
                        $this->em->remove($paqssse);
                    }
                }
            }
            //reset if needed
            $this->resetNbEnvironment($evenement);
            $this->resetNbCorporel($evenement);
            $this->resetNbSituationDangereuse($evenement);
            //set gravity
            $abstractGravityService = $this->container->get('app.abstract_gravity');
            $gravity = $abstractGravityService->getGravity($evenement->getCorporel(),$evenement->getMateriel(),$evenement->getEnvironnement(),$evenement->getImpactMediatique(),$evenement->getImpactClient(),$evenement->getDysfonctionnement());
            $evenement->setGravite($gravity);            
            //event status
            $evenementStatut = $evenement->getEvenementStatut();
            if(!$evenementStatut){
                //In progress
                $evenementStatut = $this->em->getRepository('LpsaAppBundle:EvenementStatut')->findOneById(1);
                $evenement->setEvenementStatut($evenementStatut);
            }
            $this->message = $this->evenementFormHandlerStrategy->handleForm($request, $evenement);
            //listener
            $this->eventObservable->setEvent($evenement);            
            $serviceManagerListener->notify();
            
            return true;
        }
        return false;
    }

    private function resetNbSituationDangereuse(Evenement $evenement){
        if($evenement && $evenement->getCategorie()){
            $paramCategoriesId = $this->container->getParameter('categories_id');
            if($evenement->getCategorie()->getId() !== $paramCategoriesId['situation_dangereuse']){
                $evenement->setTypeSituationDangereuse(null);
            }
            if($evenement->getCategorie()->getId() !== $paramCategoriesId['accident']){
                $evenement->setTypeAccident(null);
            }
        }
    }
    
    /**
     * Self copy relationship
     * 
     * @param ArrayCollection $orginals
     * @return ArrayCollection
     */
    private function copyArrayCollection($orginals){
        $copy = new ArrayCollection();
        foreach($orginals as $original){
            $copy->add($original);
        }
        return $copy;
    }
    
    /**
     * Rest nbCorporel
     * @param Evenement $evenement
     */
    private function resetNbCorporel(Evenement $evenement){
        if($evenement && $evenement->getCorporel()){
            if($evenement->getCorporel()->getTypeCorporel()->getId() !== 1){
                $evenement->setNbreTiers(0);
            }
        } else {
            //reset all
            $evenement->setNbreContracte(0);
            $evenement->setNbreLpsa(0);
            $evenement->setNbreTiers(0);
        }
    }
    
    /**
     * Reset nbEnvironment if environment <1m3
     * 
     * @param Evenement $evenement
     */
    private function resetNbEnvironment(Evenement $evenement){
        if($evenement && $evenement->getEnvironnement()){
            $environmentVisibles = $this->em->getRepository('LpsaAppBundle:Environnement')->findAllEnvironnementWhereInputIsVisible();
            $environmentIds = array();
            foreach ($environmentVisibles as $env){
                $environmentIds[] = $env->getId();
            }
            if(!in_array($evenement->getEnvironnement()->getId(),$environmentIds)){
                $evenement->setNbreEnvironnement(0);
            }
        }
    }
    
    /**
     * Check if EvenemetActionProgres is not "empty"
     * @param EvenementActionProgres $evtActionProgres
     * @return bool
     */
    protected function checkValidEvtActionProgres(EvenementActionProgres $evtActionProgres){
        return !empty($evtActionProgres->getAction()) || !empty($evtActionProgres->getAvancement()) || !empty($evtActionProgres->getDelai())
               || !empty($evtActionProgres->getObservation()) || !empty($evtActionProgres->getResponsableService()) || !empty($evtActionProgres->getEvenementActionProgresStatus());
    }
    
    /**
     * Remove if file upload not found
     * @param Evenement $evenement
     */
    protected function cleanForAttachmentError(Evenement $evenement){
        foreach ($evenement->getDescriptionFaitPJs() as $attachment) {
            if(($attachment->getId() === null) && (! $attachment->getFile() instanceof UploadedFile)){
                $evenement->getDescriptionFaitPJs()->removeElement($attachment);
            }
        }
        foreach ($evenement->getNarrationPJs() as $attachment) {
            if(($attachment->getId() === null) && (! $attachment->getFile() instanceof UploadedFile)){
                $evenement->getNarrationPJs()->removeElement($attachment);
            }
        }
        $enquete = $evenement->getEvenementEnquete();
        if($enquete){
            foreach ($enquete->getEvenementEnquetePJs() as $attachment) {
                if(($attachment->getId() === null) && (! $attachment->getFile() instanceof UploadedFile)){
                    $evenement->getEvenementEnquete()->getEvenementEnquetePJs()->removeElement($attachment);
                }
            }
        }
    }
    
    public function createForm(Evenement $evenement,$route,$hasAccess = true)
    {
        return $this->evenementFormHandlerStrategy->createForm($evenement,$route,$hasAccess);
    }
 
    public function createView()
    {
        return $this->evenementFormHandlerStrategy->createView();
    }
    
    /**
     * Get message for flash
     * 
     * @return string
     */
    public function getMessage(){
        return $this->message;
    }
}
