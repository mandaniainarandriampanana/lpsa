<?php

namespace Lpsa\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Lpsa\AppBundle\Entity\Dysfonctionnement;

/**
 * Dysfonctionnement controller.
 *
 */
class DysfonctionnementController extends Controller
{
    /**
     * Lists all Dysfonctionnement entities.
     *
     */
    public function indexAction()
    {
        $dysfonctionnements = $this->getDysfonctionnementManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:Dysfonctionnement:index.html.twig', array(
            'dysfonctionnements' => $dysfonctionnements,
        ));
    }

    /**
     * Displays a form to edit an existing Dysfonctionnement entity.
     *
     */
    public function newEditAction(Request $request, Dysfonctionnement $dysfonctionnement=null)
    {
       $dysfonctionnementProcess = $this->getDysfonctionnementFormHandler()->processForm($dysfonctionnement);
        $form = $this->getDysfonctionnementFormHandler()->createForm($dysfonctionnementProcess);
 
        if ($this->getDysfonctionnementFormHandler()->handleForm($form, $dysfonctionnementProcess, $request)) {
            $this->addFlash('success', $this->getDysfonctionnementFormHandler()->getMessage());

            return $this->redirectToRoute('admin_dysfonctionnement_edit', array('id' => $dysfonctionnementProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:Dysfonctionnement:newEdit.html.twig', array(
            'form' => $form->createView(),
            'dysfonctionnement' => $dysfonctionnementProcess,
        ));
    }

    /**
     * Deletes a Dysfonctionnement entity.
     *
     */
    public function deleteAction(Request $request, Dysfonctionnement $dysfonctionnement)
    {
        $this->getDysfonctionnementManager()->remove($dysfonctionnement);
        $this->addFlash('success', $this->get('translator')->trans('dysfonctionnement.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('admin_dysfonctionnement_index');
    }
    
    private function getDysfonctionnementManager(){
        return $this->get('app.dysfonctionnement.manager');
    }
    private function getDysfonctionnementFormHandler(){
        return $this->get('app.dysfonctionnement.form.handler');
    }
}
