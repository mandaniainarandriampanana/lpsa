<?php

namespace Lpsa\AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Filesystem\Filesystem;
use Lpsa\AppBundle\Entity\Evenement;

class EvenementUploadListener {    

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Evenement) {
            return;
        }
        //cleanup directory before delete event
        $em = $args->getEntityManager();
        $this->removeNarrationPj($entity, $em);
        $this->removeDescriptionPj($entity, $em);
        $this->removeEvenementEnquetePj($entity, $em);
    }
    
    /**
     * Cleanup NarrationPJ directory
     * @param Evenement $entity
     * @param ObjectManager $em
     */
    private function removeNarrationPj(Evenement $entity,$em){
        $narrationPjs = $entity->getNarrationPJs();
        $uploadDirNarration = '';
        foreach($narrationPjs as $narrationPj){
            $uploadDirNarration = $narrationPj->getUploadRootDir();
            $entity->getNarrationPJs()->removeElement($narrationPj);                    
            $em->remove($narrationPj);
        }
        $fs = new Filesystem();
        if(!empty($uploadDirNarration)){
            $fs->remove($uploadDirNarration);
        }
    }
    
    /**
     * Cleanup DescriptionPJ directory
     * @param Evenement $entity
     * @param ObjectManager $em
     */
    private function removeDescriptionPj(Evenement $entity,$em){
        $descriptionPjs = $entity->getDescriptionFaitPJs();
        $uploadDirDescription = '';
        foreach($descriptionPjs as $descriptionPj){
            $uploadDirDescription = $descriptionPj->getUploadRootDir();
            $entity->getDescriptionFaitPJs()->removeElement($descriptionPj);                    
            $em->remove($descriptionPj);
        }
        $fs = new Filesystem();
        if(!empty($uploadDirDescription)){
            $fs->remove($uploadDirDescription);
        }   
    }
    
    /**
     * Cleanup EvenementEquetePJ directory
     * @param Evenement $entity
     * @param ObjectManager $em
     */
    private function removeEvenementEnquetePj(Evenement $entity,$em){
        $evenementEnquete = $entity->getEvenementEnquete();
        if($evenementEnquete){
            $enquetePjs = $evenementEnquete->getEvenementEnquetePJs();
            $uploadDirEnquete = '';
            foreach($enquetePjs as $enquetePj){
                $uploadDirEnquete = $enquetePj->getUploadRootDir();
                $entity->getDescriptionFaitPJs()->removeElement($enquetePj);                    
                $em->remove($enquetePj);
            }
            $fs = new Filesystem();
            if(!empty($uploadDirEnquete)){
                $fs->remove($uploadDirEnquete);
            }             
        }
    }
}
