<?php

namespace Lpsa\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Lpsa\AppBundle\Entity\ImpactMediatique;

/**
 * ImpactMediatique controller.
 *
 */
class ImpactMediatiqueController extends Controller
{
    /**
     * Lists all ImpactMediatique entities.
     *
     */
    public function indexAction()
    {
        $impactMediatiques = $this->getImpactMediatiqueManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:ImpactMediatique:index.html.twig', array(
            'impactMediatiques' => $impactMediatiques,
        ));
    }
    public function newEditAction(Request $request, ImpactMediatique $impactMediatique=null)
    {
        $impactMediatiqueProcess = $this->getImpactMediatiqueFormHandler()->processForm($impactMediatique);
        $form = $this->getImpactMediatiqueFormHandler()->createForm($impactMediatiqueProcess);
 
        if ($this->getImpactMediatiqueFormHandler()->handleForm($form, $impactMediatiqueProcess, $request)) {
            $this->addFlash('success', $this->getImpactMediatiqueFormHandler()->getMessage());
            return $this->redirectToRoute('impactmediatique_edit', array('id' => $impactMediatiqueProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:ImpactMediatique:newEdit.html.twig', array(
            'form' => $form->createView(),
            'impactMediatique' => $impactMediatiqueProcess,
        ));
    }

    /**
     * Deletes a ImpactMediatique entity.
     *
     */
    public function deleteAction(Request $request, ImpactMediatique $impactMediatique)
    {
        $this->getImpactMediatiqueManager()->remove($impactMediatique);
        $this->addFlash('success', $this->get('translator')->trans('impactmediatique.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('impactmediatique_index');
    }

    public function getImpactMediatiqueManager(){
        return $this->get('app.impactmediatique.manager');
    }
    private function getImpactMediatiqueFormHandler(){
        return $this->get('app.impactmediatique.form.handler');
    }
}
