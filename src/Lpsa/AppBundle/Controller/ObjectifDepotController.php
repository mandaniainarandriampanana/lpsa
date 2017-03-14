<?php

namespace Lpsa\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Lpsa\AppBundle\Entity\ObjectifDepot;

/**
 * ObjectifDepot controller.
 *
 */
class ObjectifDepotController extends Controller
{
    /**
     * Lists all ObjectifDepot entities.
     *
     */
    public function indexAction(Request $request)
    {
        $query = $this->getObjectifDepotManager()->getRepository()->fetchAll();
        $paginator  = $this->get('knp_paginator');
        $objectifdepots = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $this->getParameter('nb_event_per_page')
        );
        return $this->render('LpsaAppBundle:ObjectifDepot:index.html.twig', array(
            'objectifdepots' => $objectifdepots,
        ));
    }
    public function newEditAction(Request $request, ObjectifDepot $objectifdepot=null)
    {
        $objectifdepotProcess = $this->getObjectifDepotFormHandler()->processForm($objectifdepot);
        $form = $this->getObjectifDepotFormHandler()->createForm($objectifdepotProcess);
 
        if ($this->getObjectifDepotFormHandler()->handleForm($form, $objectifdepotProcess, $request)) {
            $this->addFlash('success', $this->getObjectifDepotFormHandler()->getMessage());
            return $this->redirectToRoute('objectifdepot_edit', array('id' => $objectifdepotProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:ObjectifDepot:newEdit.html.twig', array(
            'form' => $form->createView(),
            'objectifdepot' => $objectifdepotProcess,
        ));
    }

    /**
     * Deletes a ObjectifDepot entity.
     *
     */
    public function deleteAction(Request $request, ObjectifDepot $objectifdepot)
    {
        $this->getObjectifDepotManager()->remove($objectifdepot);
        $this->addFlash('success', $this->get('translator')->trans('objectifdepot.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('objectifdepot_index');
    }

    public function getObjectifDepotManager(){
        return $this->get('app.objectifdepot.manager');
    }
    private function getObjectifDepotFormHandler(){
        return $this->get('app.objectifdepot.form.handler');
    }
}
