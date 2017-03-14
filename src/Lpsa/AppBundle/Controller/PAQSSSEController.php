<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\PAQSSSE;

/**
 * PAQSSSE controller.
 *
 */
class PAQSSSEController extends Controller
{
    /**
     * Lists all PAQSSSE entities.
     *
     */
    public function indexAction()
    {
        $PAQSSSEs = $this->getPAQSSSEManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:PAQSSSE:index.html.twig', array(
            'PAQSSSEs' => $PAQSSSEs,
        ));
    }
    
    public function newEditAction(Request $request, PAQSSSE $PAQSSSE = null)
    {
        $PAQSSSEProcess = $this->getPAQSSSEFormHandler()->processForm($PAQSSSE);
        $form = $this->getPAQSSSEFormHandler()->createForm($PAQSSSEProcess);
 
        if ($this->getPAQSSSEFormHandler()->handleForm($form, $PAQSSSEProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getPAQSSSEFormHandler()->getMessage());
 
            return $this->redirectToRoute('PAQSSSE_edit', array('id' => $PAQSSSEProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:PAQSSSE:newEdit.html.twig', array(
            'form' => $form->createView(),
            'PAQSSSE' => $PAQSSSEProcess
        )); 
    }
    
    /**
     * Delete a PAQSSSE entity.
     *
     */
    public function deleteAction(Request $request,PAQSSSE $PAQSSSE)
    {
        $this->getPAQSSSEManager()->remove($PAQSSSE);
        $this->addFlash('success', $this->get('translator')->trans('PAQSSSE.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('PAQSSSE_index');
    }
    
    public function getPAQSSSEFormHandler()
    {
        return $this->get('app.PAQSSSE.form.handler');
    }
    
    public function getPAQSSSEManager(){
        return $this->get('app.PAQSSSE.manager');
    }
    
}
