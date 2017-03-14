<?php

namespace Lpsa\AppBundle\Form\Handler\Dysfonctionnement;

use Lpsa\AppBundle\Entity\Dysfonctionnement;
use Lpsa\AppBundle\Form\Type\Dysfonctionnement\DysfonctionnementType;
use Symfony\Component\HttpFoundation\Request;

class UpdateDysfonctionnementFormHandlerStrategy extends AbstractDysfonctionnementFormHandlerStrategy{
    
    public function createForm(Dysfonctionnement $dysfonctionnement)
    {
        $this->form = $this->formFactory->create(new DysfonctionnementType(), $dysfonctionnement, array(
            'action' => $this->router->generate('admin_dysfonctionnement_edit',array('id' => $dysfonctionnement->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Dysfonctionnement $dysfonctionnement)
    {

        $this->dysfonctionnementManager->save($dysfonctionnement, false, true);

        return $this->translator->trans('dysfonctionnement.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
