<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\ResponsableService;

/**
 * ResponsableService controller.
 *
 */
class ResponsableServiceController extends Controller
{
    /**
     * Lists all ResponsableService entities.
     *
     */
    public function indexAction()
    {
        $responsableServices = $this->getResponsableServiceManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:ResponsableService:index.html.twig', array(
            'responsableServices' => $responsableServices,
        ));
    }
    
    public function newEditAction(Request $request, ResponsableService $responsableService = null)
    {
        $responsableServiceProcess = $this->getResponsableServiceFormHandler()->processForm($responsableService);
        $form = $this->getResponsableServiceFormHandler()->createForm($responsableServiceProcess);
 
        if ($this->getResponsableServiceFormHandler()->handleForm($form, $responsableServiceProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getResponsableServiceFormHandler()->getMessage());
 
            return $this->redirectToRoute('admin_responsableservice_edit', array('id' => $responsableServiceProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:ResponsableService:newEdit.html.twig', array(
            'form' => $form->createView(),
            'responsableService' => $responsableServiceProcess
        )); 
    }
    
    /**
     * Delete a ResponsableService entity.
     *
     */
    public function deleteAction(Request $request,ResponsableService $responsableService)
    {
        $this->getResponsableServiceManager()->remove($responsableService);
        $this->addFlash('success', $this->get('translator')->trans('responsableservice.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('admin_responsableservice_index');
    }
    
    public function getResponsableServiceFormHandler()
    {
        return $this->get('app.responsableservice.form.handler');
    }
    
    public function getResponsableServiceManager(){
        return $this->get('app.responsableservice.manager');
    }
    
}
