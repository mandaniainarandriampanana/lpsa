<?php

namespace Lpsa\AppBundle\Form\Handler\Gravite;

use Lpsa\AppBundle\Entity\Gravite;
use Lpsa\AppBundle\Form\Type\Gravite\GraviteType;
use Symfony\Component\HttpFoundation\Request;

class NewGraviteFormHandlerStrategy extends AbstractGraviteFormHandlerStrategy{
    public function createForm(Gravite $gravite)
    {
        $this->form = $this->formFactory->create(new GraviteType(), $gravite, array(
            'action' => $this->router->generate('admin_gravite_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Gravite $gravite)
    {
        $this->graviteManager->save($gravite, true, true);

        return $this->translator->trans('gravite.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
