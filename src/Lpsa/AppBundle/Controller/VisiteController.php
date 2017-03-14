<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\Visite;

/**
 * Visite controller.
 *
 */
class VisiteController extends Controller
{
    /**
     * Lists all Visite entities.
     *
     */
    public function indexAction()
    {
        $visites = $this->getVisiteManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:Visite:index.html.twig', array(
            'visites' => $visites,
        ));
    }
    
    public function newEditAction(Request $request, Visite $visite = null)
    {
        $visiteProcess = $this->getVisiteFormHandler()->processForm($visite);
        $form = $this->getVisiteFormHandler()->createForm($visiteProcess);
 
        if ($this->getVisiteFormHandler()->handleForm($form, $visiteProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getVisiteFormHandler()->getMessage());
 
            return $this->redirectToRoute('visite_edit', array('id' => $visiteProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:Visite:newEdit.html.twig', array(
            'form' => $form->createView(),
            'visite' => $visiteProcess
        )); 
    }
    
    /**
     * Delete a Visite entity.
     *
     */
    public function deleteAction(Request $request,Visite $visite)
    {
        $this->getVisiteManager()->remove($visite);
        $this->addFlash('success', $this->get('translator')->trans('visite.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('visite_index');
    }
    
    public function getVisiteFormHandler()
    {
        return $this->get('app.visite.form.handler');
    }
    
    public function getVisiteManager(){
        return $this->get('app.visite.manager');
    }
    
}
