<?php

namespace Lpsa\AppBundle\Form\Handler\ImpactClient;

use Lpsa\AppBundle\Entity\ImpactClient;
use Lpsa\AppBundle\Form\Type\ImpactClient\ImpactClientType;
use Symfony\Component\HttpFoundation\Request;

class NewImpactClientFormHandlerStrategy extends AbstractImpactClientFormHandlerStrategy{
    public function createForm(ImpactClient $impactclient)
    {
        $this->form = $this->formFactory->create(new ImpactClientType(), $impactclient, array(
            'action' => $this->router->generate('impactclient_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, ImpactClient $impactclient, ArrayCollection $originalHashTags = null)
    {
        $this->impactclientManager->save($impactclient, true, true);

        return $this->translator->trans('impactclient.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
