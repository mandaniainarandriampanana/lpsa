<?php

namespace Lpsa\AppBundle\Form\Handler\ImpactClient;

use Lpsa\AppBundle\Entity\ImpactClient;
use Lpsa\AppBundle\Form\Type\ImpactClient\ImpactClientType;
use Symfony\Component\HttpFoundation\Request;

class UpdateImpactClientFormHandlerStrategy extends AbstractImpactClientFormHandlerStrategy{
    
    public function createForm(ImpactClient $impactclient)
    {
        $this->form = $this->formFactory->create(new ImpactClientType(), $impactclient, array(
            'action' => $this->router->generate('impactclient_edit',array('id' => $impactclient->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, ImpactClient $impactclient)
    {

        $this->impactclientManager->save($impactclient, false, true);

        return $this->translator->trans('impactclient.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
