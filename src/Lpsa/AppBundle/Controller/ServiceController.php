<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\Service;

/**
 * Service controller.
 *
 */
class ServiceController extends Controller
{
    /**
     * Lists all Service entities.
     *
     */
    public function indexAction()
    {
        $services = $this->getServiceManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:Service:index.html.twig', array(
            'services' => $services,
        ));
    }
    
    public function newEditAction(Request $request, Service $service = null)
    {
        $serviceProcess = $this->getServiceFormHandler()->processForm($service);
        $form = $this->getServiceFormHandler()->createForm($serviceProcess);
 
        if ($this->getServiceFormHandler()->handleForm($form, $serviceProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getServiceFormHandler()->getMessage());
 
            return $this->redirectToRoute('service_edit', array('id' => $serviceProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:Service:newEdit.html.twig', array(
            'form' => $form->createView(),
            'service' => $serviceProcess
        )); 
    }
    
    /**
     * Delete a Service entity.
     *
     */
    public function deleteAction(Request $request,Service $service)
    {
        $this->getServiceManager()->remove($service);
        $this->addFlash('success', $this->get('translator')->trans('service.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('service_index');
    }
    
    public function getServiceFormHandler()
    {
        return $this->get('app.service.form.handler');
    }
    
    public function getServiceManager(){
        return $this->get('app.service.manager');
    }
    
}
