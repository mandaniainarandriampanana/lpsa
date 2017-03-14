<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\FuiteProduit;

/**
 * FuiteProduit controller.
 *
 */
class FuiteProduitController extends Controller
{
    /**
     * Lists all FuiteProduit entities.
     *
     */
    public function indexAction()
    {
        $fuiteProduits = $this->getFuiteProduitManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:FuiteProduit:index.html.twig', array(
            'fuiteProduits' => $fuiteProduits,
        ));
    }
    
    public function newEditAction(Request $request, FuiteProduit $fuiteProduit = null)
    {
        $fuiteProduitProcess = $this->getFuiteProduitFormHandler()->processForm($fuiteProduit);
        $form = $this->getFuiteProduitFormHandler()->createForm($fuiteProduitProcess);
 
        if ($this->getFuiteProduitFormHandler()->handleForm($form, $fuiteProduitProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getFuiteProduitFormHandler()->getMessage());
 
            return $this->redirectToRoute('admin_fuiteProduit_edit', array('id' => $fuiteProduitProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:FuiteProduit:newEdit.html.twig', array(
            'form' => $form->createView(),
            'fuiteProduit' => $fuiteProduitProcess
        )); 
    }
    
    /**
     * Delete a FuiteProduit entity.
     *
     */
    public function deleteAction(Request $request,FuiteProduit $fuiteProduit)
    {
        $this->getFuiteProduitManager()->remove($fuiteProduit);
        $this->addFlash('success', $this->get('translator')->trans('fuiteProduit.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('admin_fuiteProduit_index');
    }
    
    public function getFuiteProduitFormHandler()
    {
        return $this->get('app.fuiteProduit.form.handler');
    }
    
    public function getFuiteProduitManager(){
        return $this->get('app.fuiteProduit.manager');
    }
    
}
