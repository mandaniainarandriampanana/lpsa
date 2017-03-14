<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\Decanteur;

/**
 * Decanteur controller.
 *
 */
class DecanteurController extends Controller
{
    /**
     * Lists all Decanteur entities.
     *
     */
    public function indexAction()
    {
        $decanteurs = $this->getDecanteurManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:Decanteur:index.html.twig', array(
            'decanteurs' => $decanteurs,
        ));
    }
    
    public function newEditAction(Request $request, Decanteur $decanteur = null)
    {
        $decanteurProcess = $this->getDecanteurFormHandler()->processForm($decanteur);
        $form = $this->getDecanteurFormHandler()->createForm($decanteurProcess);
 
        if ($this->getDecanteurFormHandler()->handleForm($form, $decanteurProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getDecanteurFormHandler()->getMessage());
 
            return $this->redirectToRoute('decanteur_edit', array('id' => $decanteurProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:Decanteur:newEdit.html.twig', array(
            'form' => $form->createView(),
            'decanteur' => $decanteurProcess
        )); 
    }
    
    /**
     * Delete a Decanteur entity.
     *
     */
    public function deleteAction(Request $request,Decanteur $decanteur)
    {
        $this->getDecanteurManager()->remove($decanteur);
        $this->addFlash('success', $this->get('translator')->trans('decanteur.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('decanteur_index');
    }
    
    public function getDecanteurFormHandler()
    {
        return $this->get('app.decanteur.form.handler');
    }
    
    public function getDecanteurManager(){
        return $this->get('app.decanteur.manager');
    }
    
}
