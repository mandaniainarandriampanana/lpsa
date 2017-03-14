<?php

namespace Lpsa\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Lpsa\AppBundle\Entity\EvenementActionProgresStatus;

/**
 * EvenementActionProgresStatus controller.
 *
 */
class EvenementActionProgresStatusController extends Controller
{
    /**
     * Lists all EvenementActionProgresStatus entities.
     *
     */
    public function indexAction()
    {
        $evenementActionProgresStatuss = $this->getEvenementActionProgresStatusManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:EvenementActionProgresStatus:index.html.twig', array(
            'evenementActionProgresStatuss' => $evenementActionProgresStatuss,
        ));
    }
    
    public function newEditAction(Request $request, EvenementActionProgresStatus $evenementActionProgresStatus=null)
    {
        $evenementActionProgresStatusProcess = $this->getEvenementActionProgresStatusFormHandler()->processForm($evenementActionProgresStatus);
        $form = $this->getEvenementActionProgresStatusFormHandler()->createForm($evenementActionProgresStatusProcess);
 
        if ($this->getEvenementActionProgresStatusFormHandler()->handleForm($form, $evenementActionProgresStatusProcess, $request)) {
            $this->addFlash('success', $this->getEvenementActionProgresStatusFormHandler()->getMessage());
 
            return $this->redirectToRoute('evenementactionprogresstatus_edit', array('id' => $evenementActionProgresStatusProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:EvenementActionProgresStatus:newEdit.html.twig', array(
            'form' => $form->createView(),
            'evenementActionProgresStatus' => $evenementActionProgresStatusProcess,
        ));
    }

    /**
     * Deletes a EvenementActionProgresStatus entity.
     *
     */
    public function deleteAction(Request $request, EvenementActionProgresStatus $evenementActionProgresStatus)
    {
        $this->getEvenementActionProgresStatusManager()->remove($evenementActionProgresStatus);
        $this->addFlash('success', $this->get('translator')->trans('evenementactionprogresstatus.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('evenementactionprogresstatus_index');
    }
    
    private function getEvenementActionProgresStatusManager(){
        return $this->get('app.evenementactionprogresstatus.manager');
    }
    private function getEvenementActionProgresStatusFormHandler(){
        return $this->get('app.evenementactionprogresstatus.form.handler');
    }
}
