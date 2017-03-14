<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\EvenementStatut;

/**
 * EvenementStatut controller.
 *
 */
class EvenementStatutController extends Controller
{
    /**
     * Lists all EvenementStatut entities.
     *
     */
    public function indexAction()
    {
        $evenementStatus = $this->getEvenementStatutManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:EvenementStatut:index.html.twig', array(
            'evenementStatus' => $evenementStatus,
        ));
    }
    
    public function newEditAction(Request $request, EvenementStatut $evenementStatut = null)
    {
        $evenementStatutProcess = $this->getEvenementStatutFormHandler()->processForm($evenementStatut);
        $form = $this->getEvenementStatutFormHandler()->createForm($evenementStatutProcess);
 
        if ($this->getEvenementStatutFormHandler()->handleForm($form, $evenementStatutProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getEvenementStatutFormHandler()->getMessage());
 
            return $this->redirectToRoute('evenementstatut_edit', array('id' => $evenementStatutProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:EvenementStatut:newEdit.html.twig', array(
            'form' => $form->createView(),
            'evenementStatut' => $evenementStatutProcess
        )); 
    }
    
    /**
     * Delete a EvenementStatut entity.
     *
     */
    public function deleteAction(Request $request,EvenementStatut $evenementStatut)
    {
        $this->getEvenementStatutManager()->remove($evenementStatut);
        $this->addFlash('success', $this->get('translator')->trans('evenementstatut.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('evenementstatut_index');
    }
    
    public function getEvenementStatutFormHandler()
    {
        return $this->get('app.evenementstatut.form.handler');
    }
    
    public function getEvenementStatutManager(){
        return $this->get('app.evenementstatut.manager');
    }
    
}
