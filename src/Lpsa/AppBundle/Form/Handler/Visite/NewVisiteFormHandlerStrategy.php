<?php

namespace Lpsa\AppBundle\Form\Handler\Visite;

use Lpsa\AppBundle\Entity\Visite;
use Lpsa\AppBundle\Form\Type\Visite\VisiteType;
use Symfony\Component\HttpFoundation\Request;

class NewVisiteFormHandlerStrategy extends AbstractVisiteFormHandlerStrategy{
    public function createForm(Visite $visite)
    {
        $this->form = $this->formFactory->create(new VisiteType(), $visite, array(
            'action' => $this->router->generate('visite_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Visite $visite)
    {
        $this->visiteManager->save($visite, true, true);

        return $this->translator->trans('visite.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
