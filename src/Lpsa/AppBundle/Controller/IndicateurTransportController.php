<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\IndicateurTransport;

/**
 * IndicateurTransport controller.
 *
 */
class IndicateurTransportController extends Controller
{
    /**
     * Lists all IndicateurTransport entities.
     *
     */
    public function indexAction()
    {
        $indicateurTransports = $this->getIndicateurTransportManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:IndicateurTransport:index.html.twig', array(
            'indicateurTransports' => $indicateurTransports,
        ));
    }
    
    public function newEditAction(Request $request, IndicateurTransport $indicateurTransport = null)
    {
        $indicateurTransportProcess = $this->getIndicateurTransportFormHandler()->processForm($indicateurTransport);
        $form = $this->getIndicateurTransportFormHandler()->createForm($indicateurTransportProcess);
 
        if ($this->getIndicateurTransportFormHandler()->handleForm($form, $indicateurTransportProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getIndicateurTransportFormHandler()->getMessage());
 
            return $this->redirectToRoute('indicateurTransport_edit', array('id' => $indicateurTransportProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:IndicateurTransport:newEdit.html.twig', array(
            'form' => $form->createView(),
            'indicateurTransport' => $indicateurTransportProcess
        )); 
    }
    
    /**
     * Delete a IndicateurTransport entity.
     *
     */
    public function deleteAction(Request $request,IndicateurTransport $indicateurTransport)
    {
        $this->getIndicateurTransportManager()->remove($indicateurTransport);
        $this->addFlash('success', $this->get('translator')->trans('indicateurTransport.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('indicateurTransport_index');
    }
    
    public function getIndicateurTransportFormHandler()
    {
        return $this->get('app.indicateurTransport.form.handler');
    }
    
    public function getIndicateurTransportManager(){
        return $this->get('app.indicateurTransport.manager');
    }
    
}
