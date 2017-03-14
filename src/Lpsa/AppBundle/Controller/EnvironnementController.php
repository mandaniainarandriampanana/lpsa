<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\Environnement;

/**
 * Environnement controller.
 *
 */
class EnvironnementController extends Controller
{
    /**
     * Lists all Environnement entities.
     *
     */
    public function indexAction()
    {
        $environnements = $this->getEnvironnementManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:Environnement:index.html.twig', array(
            'environnements' => $environnements,
        ));
    }
    
    public function newEditAction(Request $request, Environnement $environnement = null)
    {
        $environnementProcess = $this->getEnvironnementFormHandler()->processForm($environnement);
        $form = $this->getEnvironnementFormHandler()->createForm($environnementProcess);
 
        if ($this->getEnvironnementFormHandler()->handleForm($form, $environnementProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getEnvironnementFormHandler()->getMessage());
 
            return $this->redirectToRoute('environnement_edit', array('id' => $environnementProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:Environnement:newEdit.html.twig', array(
            'form' => $form->createView(),
            'environnement' => $environnementProcess
        )); 
    }
    
    /**
     * Delete a Environnement entity.
     *
     */
    public function deleteAction(Request $request,Environnement $environnement)
    {
        $this->getEnvironnementManager()->remove($environnement);
        $this->addFlash('success', $this->get('translator')->trans('environnement.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('environnement_index');
    }
    
    public function getEnvironnementFormHandler()
    {
        return $this->get('app.environnement.form.handler');
    }
    
    public function getEnvironnementManager(){
        return $this->get('app.environnement.manager');
    }
    
}
