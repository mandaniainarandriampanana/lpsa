<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\HeureTravail;

/**
 * HeureTravail controller.
 *
 */
class HeureTravailController extends Controller
{
    /**
     * Lists all HeureTravail entities.
     *
     */
    public function indexAction()
    {
        $heureTravailx = $this->getHeureTravailManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:HeureTravail:index.html.twig', array(
            'heureTravailx' => $heureTravailx,
        ));
    }
    
    public function newEditAction(Request $request, HeureTravail $heureTravail = null)
    {
        $heureTravailProcess = $this->getHeureTravailFormHandler()->processForm($heureTravail);
        $form = $this->getHeureTravailFormHandler()->createForm($heureTravailProcess);
 
        if ($this->getHeureTravailFormHandler()->handleForm($form, $heureTravailProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getHeureTravailFormHandler()->getMessage());
 
            return $this->redirectToRoute('heuretravail_edit', array('id' => $heureTravailProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:HeureTravail:newEdit.html.twig', array(
            'form' => $form->createView(),
            'heureTravail' => $heureTravailProcess
        )); 
    }
    
    /**
     * Delete a HeureTravail entity.
     *
     */
    public function deleteAction(Request $request,HeureTravail $heureTravail)
    {
        $this->getHeureTravailManager()->remove($heureTravail);
        $this->addFlash('success', $this->get('translator')->trans('heuretravail.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('heuretravail_index');
    }
    
    public function getHeureTravailFormHandler()
    {
        return $this->get('app.heuretravail.form.handler');
    }
    
    public function getHeureTravailManager(){
        return $this->get('app.heuretravail.manager');
    }
    
}
