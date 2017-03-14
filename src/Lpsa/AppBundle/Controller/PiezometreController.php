<?php

namespace Lpsa\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lpsa\AppBundle\Entity\Piezometre;

/**
 * Piezometre controller.
 *
 */
class PiezometreController extends Controller
{
    /**
     * Lists all Piezometre entities.
     *
     */
    public function indexAction()
    {
        $piezometres = $this->getPiezometreManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:Piezometre:index.html.twig', array(
            'piezometres' => $piezometres,
        ));
    }
    
    public function newEditAction(Request $request, Piezometre $piezometre = null)
    {
        $piezometreProcess = $this->getPiezometreFormHandler()->processForm($piezometre);
        $form = $this->getPiezometreFormHandler()->createForm($piezometreProcess);
 
        if ($this->getPiezometreFormHandler()->handleForm($form, $piezometreProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getPiezometreFormHandler()->getMessage());
 
            return $this->redirectToRoute('piezometre_edit', array('id' => $piezometreProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:Piezometre:newEdit.html.twig', array(
            'form' => $form->createView(),
            'piezometre' => $piezometreProcess
        )); 
    }
    
    /**
     * Delete a Piezometre entity.
     *
     */
    public function deleteAction(Request $request,Piezometre $piezometre)
    {
        $this->getPiezometreManager()->remove($piezometre);
        $this->addFlash('success', $this->get('translator')->trans('piezometre.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('piezometre_index');
    }
    
    public function getPiezometreFormHandler()
    {
        return $this->get('app.piezometre.form.handler');
    }
    
    public function getPiezometreManager(){
        return $this->get('app.piezometre.manager');
    }
    
}
