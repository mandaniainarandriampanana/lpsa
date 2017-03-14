<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\ObjectifKpihse;

/**
 * ObjectifKpihse controller.
 *
 */
class ObjectifKpihseController extends Controller
{
    /**
     * Lists all ObjectifKpihse entities.
     *
     */
    public function indexAction()
    {
        $objectifKpihses = $this->getObjectifKpihseManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:ObjectifKpihse:index.html.twig', array(
            'objectifKpihses' => $objectifKpihses,
        ));
    }
    
    public function newEditAction(Request $request, ObjectifKpihse $objectifKpihse = null)
    {
        $objectifKpihseProcess = $this->getObjectifKpihseFormHandler()->processForm($objectifKpihse);
        $form = $this->getObjectifKpihseFormHandler()->createForm($objectifKpihseProcess);
 
        if ($this->getObjectifKpihseFormHandler()->handleForm($form, $objectifKpihseProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getObjectifKpihseFormHandler()->getMessage());
 
            return $this->redirectToRoute('objectifKpihse_edit', array('id' => $objectifKpihseProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:ObjectifKpihse:newEdit.html.twig', array(
            'form' => $form->createView(),
            'objectifKpihse' => $objectifKpihseProcess
        )); 
    }
    
    /**
     * Delete a ObjectifKpihse entity.
     *
     */
    public function deleteAction(Request $request,ObjectifKpihse $objectifKpihse)
    {
        $this->getObjectifKpihseManager()->remove($objectifKpihse);
        $this->addFlash('success', $this->get('translator')->trans('objectifKpihse.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('objectifKpihse_index');
    }
    
    public function getObjectifKpihseFormHandler()
    {
        return $this->get('app.objectifKpihse.form.handler');
    }
    
    public function getObjectifKpihseManager(){
        return $this->get('app.objectifKpihse.manager');
    }
    
}
