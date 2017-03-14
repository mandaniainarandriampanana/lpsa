<?php

namespace Lpsa\AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Filesystem\Filesystem;
use Lpsa\AppBundle\Entity\Toolbox;

class ToolboxUploadListener {    

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Toolbox) {
            return;
        }
        //cleanup directory before delete event
        $em = $args->getEntityManager();
        $this->removeToolboxPj($entity, $em);
    }
    
    /**
     * Cleanup ToolboxPJ directory
     * @param Toolbox $entity
     * @param ObjectManager $em
     */
    private function removeToolboxPj(Toolbox $entity,$em){
        $toolboxPjs = $entity->getToolboxPjs();
        $uploadDirToolbox = '';
        foreach($toolboxPjs as $toolboxPj){
            $uploadDirToolbox = $toolboxPj->getUploadRootDir();
            $entity->getToolboxPjs()->removeElement($toolboxPj);                    
            $em->remove($toolboxPj);
        }
        $fs = new Filesystem();
        if(!empty($uploadDirToolbox)){
            $fs->remove($uploadDirToolbox);
        }
    }
}
