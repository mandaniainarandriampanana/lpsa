<?php

namespace Lpsa\AppBundle\Form\Handler\Gravite;

use Lpsa\AppBundle\Entity\Gravite;
use Lpsa\AppBundle\Form\Type\Gravite\GraviteType;
use Symfony\Component\HttpFoundation\Request;

class UpdateGraviteFormHandlerStrategy extends AbstractGraviteFormHandlerStrategy{
    
    public function createForm(Gravite $gravite)
    {
        $this->form = $this->formFactory->create(new GraviteType(), $gravite, array(
            'action' => $this->router->generate('admin_gravite_edit',array('id' => $gravite->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Gravite $gravite)
    {

        $this->graviteManager->save($gravite, false, true);

        return $this->translator->trans('gravite.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
