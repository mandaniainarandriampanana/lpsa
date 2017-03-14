<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\Departement;

/**
 * Departement controller.
 *
 */
class DepartementController extends Controller
{
    /**
     * Lists all Departement entities.
     *
     */
    public function indexAction()
    {
        $departements = $this->getDepartementManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:Departement:index.html.twig', array(
            'departements' => $departements,
        ));
    }
    
    public function newEditAction(Request $request, Departement $departement = null)
    {
        $departementProcess = $this->getDepartementFormHandler()->processForm($departement);
        $form = $this->getDepartementFormHandler()->createForm($departementProcess);
 
        if ($this->getDepartementFormHandler()->handleForm($form, $departementProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getDepartementFormHandler()->getMessage());
 
            return $this->redirectToRoute('departement_edit', array('id' => $departementProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:Departement:newEdit.html.twig', array(
            'form' => $form->createView(),
            'departement' => $departementProcess
        )); 
    }
    
    /**
     * Delete a Departement entity.
     *
     */
    public function deleteAction(Request $request,Departement $departement)
    {
        $this->getDepartementManager()->remove($departement);
        $this->addFlash('success', $this->get('translator')->trans('departement.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('departement_index');
    }
    
    public function getDepartementFormHandler()
    {
        return $this->get('app.departement.form.handler');
    }
    
    public function getDepartementManager(){
        return $this->get('app.departement.manager');
    }
    
}
