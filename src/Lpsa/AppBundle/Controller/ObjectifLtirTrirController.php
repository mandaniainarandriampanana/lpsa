<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\ObjectifLtirTrir;

/**
 * ObjectifLtirTrir controller.
 *
 */
class ObjectifLtirTrirController extends Controller
{
    /**
     * Lists all ObjectifLtirTrir entities.
     *
     */
    public function indexAction()
    {
        $objectifLtirTrirs = $this->getObjectifLtirTrirManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:ObjectifLtirTrir:index.html.twig', array(
            'objectifLtirTrirs' => $objectifLtirTrirs,
        ));
    }
    
    public function newEditAction(Request $request, ObjectifLtirTrir $objectifLtirTrir = null)
    {
        $objectifLtirTrirProcess = $this->getObjectifLtirTrirFormHandler()->processForm($objectifLtirTrir);
        $form = $this->getObjectifLtirTrirFormHandler()->createForm($objectifLtirTrirProcess);
 
        if ($this->getObjectifLtirTrirFormHandler()->handleForm($form, $objectifLtirTrirProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getObjectifLtirTrirFormHandler()->getMessage());
 
            return $this->redirectToRoute('objectifltirtrir_edit', array('id' => $objectifLtirTrirProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:ObjectifLtirTrir:newEdit.html.twig', array(
            'form' => $form->createView(),
            'objectifLtirTrir' => $objectifLtirTrirProcess
        )); 
    }
    
    /**
     * Delete a ObjectifLtirTrir entity.
     *
     */
    public function deleteAction(Request $request,ObjectifLtirTrir $objectifLtirTrir)
    {
        $this->getObjectifLtirTrirManager()->remove($objectifLtirTrir);
        $this->addFlash('success', $this->get('translator')->trans('objectifltirtrir.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('objectifltirtrir_index');
    }
    
    public function getObjectifLtirTrirFormHandler()
    {
        return $this->get('app.objectifltirtrir.form.handler');
    }
    
    public function getObjectifLtirTrirManager(){
        return $this->get('app.objectifltirtrir.manager');
    }
    
}
