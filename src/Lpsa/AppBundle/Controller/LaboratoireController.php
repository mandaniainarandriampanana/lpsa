<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\Laboratoire;

/**
 * Laboratoire controller.
 *
 */
class LaboratoireController extends Controller
{
    /**
     * Lists all Laboratoire entities.
     *
     */
    public function indexAction()
    {
        $laboratoires = $this->getLaboratoireManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:Laboratoire:index.html.twig', array(
            'laboratoires' => $laboratoires,
        ));
    }
    
    public function newEditAction(Request $request, Laboratoire $laboratoire = null)
    {
        $laboratoireProcess = $this->getLaboratoireFormHandler()->processForm($laboratoire);
        $form = $this->getLaboratoireFormHandler()->createForm($laboratoireProcess);
 
        if ($this->getLaboratoireFormHandler()->handleForm($form, $laboratoireProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getLaboratoireFormHandler()->getMessage());
 
            return $this->redirectToRoute('laboratoire_edit', array('id' => $laboratoireProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:Laboratoire:newEdit.html.twig', array(
            'form' => $form->createView(),
            'laboratoire' => $laboratoireProcess
        )); 
    }
    
    /**
     * Delete a Laboratoire entity.
     *
     */
    public function deleteAction(Request $request,Laboratoire $laboratoire)
    {
        $this->getLaboratoireManager()->remove($laboratoire);
        $this->addFlash('success', $this->get('translator')->trans('laboratoire.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('laboratoire_index');
    }
    
    public function getLaboratoireFormHandler()
    {
        return $this->get('app.laboratoire.form.handler');
    }
    
    public function getLaboratoireManager(){
        return $this->get('app.laboratoire.manager');
    }
    
}
