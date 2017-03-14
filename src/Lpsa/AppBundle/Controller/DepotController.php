<?php

namespace Lpsa\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Lpsa\AppBundle\Entity\Depot;

/**
 * Depot controller.
 *
 */
class DepotController extends Controller
{
    /**
     * Lists all Depot entities.
     *
     */
    public function indexAction()
    {
        $depots = $this->getDepotManager()->getRepository()->findBy(array(),array('libelle' => 'ASC'));
        return $this->render('LpsaAppBundle:Depot:index.html.twig', array(
            'depots' => $depots,
        ));
    }

    /**
     * Displays a form to edit an existing Depot entity.
     *
     */
    public function newEditAction(Request $request, Depot $depot=null)
    {
       $depotProcess = $this->getDepotFormHandler()->processForm($depot);
        $form = $this->getDepotFormHandler()->createForm($depotProcess);
 
        if ($this->getDepotFormHandler()->handleForm($form, $depotProcess, $request)) {
            $this->addFlash('success', $this->getDepotFormHandler()->getMessage());

            return $this->redirectToRoute('admin_depot_edit', array('id' => $depotProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:Depot:newEdit.html.twig', array(
            'form' => $form->createView(),
            'depot' => $depotProcess,
        ));
    }

    /**
     * Deletes a Depot entity.
     *
     */
    public function deleteAction(Request $request, Depot $depot)
    {
        $this->getDepotManager()->remove($depot);
        $this->addFlash('success', $this->get('translator')->trans('depot.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('admin_depot_index');
    }
    
    private function getDepotManager(){
        return $this->get('app.depot.manager');
    }
    private function getDepotFormHandler(){
        return $this->get('app.depot.form.handler');
    }
}
