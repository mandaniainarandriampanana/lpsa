<?php

namespace Lpsa\AppBundle\Form\Handler\ImpactMediatique;

use Lpsa\AppBundle\Entity\ImpactMediatique;
use Lpsa\AppBundle\Form\Type\ImpactMediatique\ImpactMediatiqueType;
use Symfony\Component\HttpFoundation\Request;

class NewImpactMediatiqueFormHandlerStrategy extends AbstractImpactMediatiqueFormHandlerStrategy{
    public function createForm(ImpactMediatique $impactmediatique)
    {
        $this->form = $this->formFactory->create(new ImpactMediatiqueType(), $impactmediatique, array(
            'action' => $this->router->generate('impactmediatique_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, ImpactMediatique $impactmediatique, ArrayCollection $originalHashTags = null)
    {
        $this->impactmediatiqueManager->save($impactmediatique, true, true);

        return $this->translator->trans('impactmediatique.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
