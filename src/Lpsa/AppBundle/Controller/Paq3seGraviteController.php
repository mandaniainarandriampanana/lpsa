<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\Paq3seGravite;

/**
 * Paq3seGravite controller.
 *
 */
class Paq3seGraviteController extends Controller
{
    /**
     * Lists all Paq3seGravite entities.
     *
     */
    public function indexAction()
    {
        $paq3seGravites = $this->getPaq3seGraviteManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:Paq3seGravite:index.html.twig', array(
            'paq3seGravites' => $paq3seGravites,
        ));
    }
    
    public function newEditAction(Request $request, Paq3seGravite $paq3seGravite = null)
    {
        $paq3seGraviteProcess = $this->getPaq3seGraviteFormHandler()->processForm($paq3seGravite);
        $form = $this->getPaq3seGraviteFormHandler()->createForm($paq3seGraviteProcess);
 
        if ($this->getPaq3seGraviteFormHandler()->handleForm($form, $paq3seGraviteProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getPaq3seGraviteFormHandler()->getMessage());
 
            return $this->redirectToRoute('admin_paq3seGravite_edit', array('id' => $paq3seGraviteProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:Paq3seGravite:newEdit.html.twig', array(
            'form' => $form->createView(),
            'paq3seGravite' => $paq3seGraviteProcess
        )); 
    }
    
    /**
     * Delete a Paq3seGravite entity.
     *
     */
    public function deleteAction(Request $request,Paq3seGravite $paq3seGravite)
    {
        $this->getPaq3seGraviteManager()->remove($paq3seGravite);
        $this->addFlash('success', $this->get('translator')->trans('paq3seGravite.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('admin_paq3seGravite_index');
    }
    
    public function getPaq3seGraviteFormHandler()
    {
        return $this->get('app.paq3seGravite.form.handler');
    }
    
    public function getPaq3seGraviteManager(){
        return $this->get('app.paq3seGravite.manager');
    }
    
}
