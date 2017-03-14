<?php

namespace Lpsa\AppBundle\Form\Handler\Departement;

use Lpsa\AppBundle\Entity\Departement;
use Lpsa\AppBundle\Form\Type\Departement\DepartementType;
use Symfony\Component\HttpFoundation\Request;

class NewDepartementFormHandlerStrategy extends AbstractDepartementFormHandlerStrategy{
    public function createForm(Departement $departement)
    {
        $this->form = $this->formFactory->create(new DepartementType(), $departement, array(
            'action' => $this->router->generate('departement_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Departement $departement)
    {
        $this->departementManager->save($departement, true, true);

        return $this->translator->trans('departement.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
