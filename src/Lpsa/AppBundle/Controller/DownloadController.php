<?php

namespace Lpsa\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Lpsa\CoreBundle\Controller\CoreController;


/**
 * DownloadController
 *
 */
class DownloadController extends CoreController
{
    
    public function getEventAttachmentAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $attachment = $em->getRepository('LpsaAppBundle:NarrationPj')->findOneById($id);
        
        //check
        $this->checkAvailability($attachment);
        $filePath = $attachment->getFullFilePath();
        $filename = $attachment->getOriginalName();
        
        // prepare BinaryFileResponse
        $response = new BinaryFileResponse($filePath);
        $response->trustXSendfileTypeHeader();
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $filename,
            iconv('UTF-8', 'ASCII//TRANSLIT', $filename)
        );

        return $response;
    }
    
    public function getDescritionAttachmentAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $attachment = $em->getRepository('LpsaAppBundle:DescriptionFaitPj')->findOneById($id);
        
        //check
        $this->checkAvailability($attachment);
        $filePath = $attachment->getFullFilePath();
        $filename = $attachment->getOriginalName();
        
        // prepare BinaryFileResponse
        $response = new BinaryFileResponse($filePath);
        $response->trustXSendfileTypeHeader();
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $filename,
            iconv('UTF-8', 'ASCII//TRANSLIT', $filename)
        );

        return $response;
    }
    
    public function getInvestigationAttachmentAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $attachment = $em->getRepository('LpsaAppBundle:EvenementEnquetePj')->findOneById($id);
        
        //check
        $this->checkAvailability($attachment);
        $filePath = $attachment->getFullFilePath();
        $filename = $attachment->getOriginalName();
        
        // prepare BinaryFileResponse
        $response = new BinaryFileResponse($filePath);
        $response->trustXSendfileTypeHeader();
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $filename,
            iconv('UTF-8', 'ASCII//TRANSLIT', $filename)
        );

        return $response;
    }

    public function getToolboxAttachmentAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $attachment = $em->getRepository('LpsaAppBundle:ToolboxPj')->findOneById($id);
        
        //check
        if(!$attachment){
            throw $this->createNotFoundException();
        }

        $toolbox = $attachment->getToolbox();

        $this->denyAccessUnlessGranted('download', $toolbox);

        $filePath = $attachment->getFullFilePath();
        // check if file exists
        $fs = new FileSystem();
        if (!$fs->exists($filePath)) {
            throw $this->createNotFoundException();
        }

        $filePath = $attachment->getFullFilePath();
        $filename = $attachment->getOriginalName();
        
        // prepare BinaryFileResponse
        $response = new BinaryFileResponse($filePath);
        $response->trustXSendfileTypeHeader();
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $filename,
            iconv('UTF-8', 'ASCII//TRANSLIT', $filename)
        );

        return $response;
    }
    
    private function checkAvailability($attachment){
        if(!$attachment){
            throw $this->createNotFoundException();
        }
        if(method_exists($attachment,'getEvenement')){
            $evenement = $attachment->getEvenement();
        } else {
            $evenement = $attachment->getEvenementEnquete()->getEvenement();
        }
        $this->denyAccessUnlessGranted('download', $evenement);

        $filePath = $attachment->getFullFilePath();
        // check if file exists
        $fs = new FileSystem();
        if (!$fs->exists($filePath)) {
            throw $this->createNotFoundException();
        }
    }
}
