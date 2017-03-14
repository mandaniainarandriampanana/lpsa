<?php

namespace Lpsa\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Lpsa\AppBundle\Entity\ImpactClient;


/**
 * ImpactClient controller.
 *
 */
class ImpactClientController extends Controller
{
    /**
     * Lists all ImpactClient entities.
     *
     */
    public function indexAction()
    {
        $impactClients = $this->getImpactClientManager()->getRepository()->findAll();
        return $this->render('LpsaAppBundle:ImpactClient:index.html.twig', array(
            'impactClients' => $impactClients,
        ));
    }
    public function newEditAction(Request $request, ImpactClient $impactClient=null)
    {
        $impactClientProcess = $this->getImpactClientFormHandler()->processForm($impactClient);
        $form = $this->getImpactClientFormHandler()->createForm($impactClientProcess);
 
        if ($this->getImpactClientFormHandler()->handleForm($form, $impactClientProcess, $request)) {
            $this->addFlash('success', $this->getImpactClientFormHandler()->getMessage());
            return $this->redirectToRoute('impactclient_edit', array('id' => $impactClientProcess->getId()));
        }
        
        return $this->render('LpsaAppBundle:ImpactClient:newEdit.html.twig', array(
            'form' => $form->createView(),
            'impactClient' => $impactClientProcess,
        ));
    }

    /**
     * Deletes a ImpactClient entity.
     *
     */
    public function deleteAction(Request $request, ImpactClient $impactClient)
    {
        $this->getImpactClientManager()->remove($impactClient);
        $this->addFlash('success', $this->get('translator')->trans('impactclient.flashes.delete.success', [], 'LpsaAppBundle', $request->getLocale()));
        return $this->redirectToRoute('impactclient_index');
    }

    public function getImpactClientManager(){
        return $this->get('app.impactclient.manager');
    }
    private function getImpactClientFormHandler(){
        return $this->get('app.impactclient.form.handler');
    }
}
