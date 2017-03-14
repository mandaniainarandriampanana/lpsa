<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\Gravite;

/**
 * Gravite controller.
 *
 */
class GraviteController extends Controller
{
    /**
     * Lists all Gravite entities.
     *
     */
    public function indexAction()
    {
        $gravites = $this->getGraviteManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:Gravite:index.html.twig', array(
            'gravites' => $gravites,
        ));
    }
    
    public function newEditAction(Request $request, Gravite $gravite = null)
    {
        $graviteProcess = $this->getGraviteFormHandler()->processForm($gravite);
        $form = $this->getGraviteFormHandler()->createForm($graviteProcess);
 
        if ($this->getGraviteFormHandler()->handleForm($form, $graviteProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getGraviteFormHandler()->getMessage());
 
            return $this->redirectToRoute('admin_gravite_edit', array('id' => $graviteProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:Gravite:newEdit.html.twig', array(
            'form' => $form->createView(),
            'gravite' => $graviteProcess
        )); 
    }
    
    /**
     * Delete a Gravite entity.
     *
     */
    public function deleteAction(Request $request,Gravite $gravite)
    {
        $this->getGraviteManager()->remove($gravite);
        $this->addFlash('success', $this->get('translator')->trans('gravite.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('admin_gravite_index');
    }
    
    public function getGraviteFormHandler()
    {
        return $this->get('app.gravite.form.handler');
    }
    
    public function getGraviteManager(){
        return $this->get('app.gravite.manager');
    }
    
}
