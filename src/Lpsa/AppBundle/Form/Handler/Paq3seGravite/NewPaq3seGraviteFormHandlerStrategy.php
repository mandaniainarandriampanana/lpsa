<?php

namespace Lpsa\AppBundle\Form\Handler\Paq3seGravite;

use Lpsa\AppBundle\Entity\Paq3seGravite;
use Lpsa\AppBundle\Form\Type\Paq3seGravite\Paq3seGraviteType;
use Symfony\Component\HttpFoundation\Request;

class NewPaq3seGraviteFormHandlerStrategy extends AbstractPaq3seGraviteFormHandlerStrategy{
    public function createForm(Paq3seGravite $paq3seGravite)
    {
        $this->form = $this->formFactory->create(new Paq3seGraviteType(), $paq3seGravite, array(
            'action' => $this->router->generate('admin_paq3seGravite_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Paq3seGravite $paq3seGravite)
    {
        $this->paq3seGraviteManager->save($paq3seGravite, true, true);

        return $this->translator->trans('paq3seGravite.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
