<?php

namespace Lpsa\AppBundle\Form\Handler\Materiel;

use Lpsa\AppBundle\Entity\Materiel;
use Lpsa\AppBundle\Form\Type\Materiel\MaterielType;
use Symfony\Component\HttpFoundation\Request;

class UpdateMaterielFormHandlerStrategy extends AbstractMaterielFormHandlerStrategy{
    
    public function createForm(Materiel $materiel)
    {
        $this->form = $this->formFactory->create(new MaterielType(), $materiel, array(
            'action' => $this->router->generate('materiel_edit',array('id' => $materiel->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Materiel $materiel)
    {

        $this->materielManager->save($materiel, false, true);

        return $this->translator->trans('materiel.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
