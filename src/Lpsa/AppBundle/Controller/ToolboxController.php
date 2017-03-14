<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\Toolbox;

/**
 * Toolbox controller.
 *
 */
class ToolboxController extends Controller
{
    /**
     * Lists all Toolbox entities.
     *
     */
    public function indexAction()
    {
        $toolboxs = $this->getToolboxManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:Toolbox:index.html.twig', array(
            'toolboxs' => $toolboxs,
        ));
    }
    
    public function newEditAction(Request $request, Toolbox $toolbox = null)
    {
        $toolboxProcess = $this->getToolboxFormHandler()->processForm($toolbox);
        $form = $this->getToolboxFormHandler()->createForm($toolboxProcess);
 
        if ($this->getToolboxFormHandler()->handleForm($form, $toolboxProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getToolboxFormHandler()->getMessage());
 
            return $this->redirectToRoute('toolbox_edit', array('id' => $toolboxProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:Toolbox:newEdit.html.twig', array(
            'form' => $form->createView(),
            'toolbox' => $toolboxProcess
        )); 
    }
    
    /**
     * Delete a Toolbox entity.
     *
     */
    public function deleteAction(Request $request,Toolbox $toolbox)
    {
        $this->getToolboxManager()->remove($toolbox);
        $this->addFlash('success', $this->get('translator')->trans('toolbox.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('toolbox_index');
    }
    
    public function getToolboxFormHandler()
    {
        return $this->get('app.toolbox.form.handler');
    }
    
    public function getToolboxManager(){
        return $this->get('app.toolbox.manager');
    }
    
}
