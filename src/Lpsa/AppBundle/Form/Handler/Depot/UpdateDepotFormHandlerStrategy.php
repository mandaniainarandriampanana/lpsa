<?php

namespace Lpsa\AppBundle\Form\Handler\Depot;

use Lpsa\AppBundle\Entity\Depot;
use Lpsa\AppBundle\Form\Type\Depot\DepotType;
use Symfony\Component\HttpFoundation\Request;

class UpdateDepotFormHandlerStrategy extends AbstractDepotFormHandlerStrategy{
    
    public function createForm(Depot $depot)
    {
        $this->form = $this->formFactory->create(new DepotType(), $depot, array(
            'action' => $this->router->generate('admin_depot_edit',array('id' => $depot->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Depot $depot)
    {

        $this->depotManager->save($depot, false, true);

        return $this->translator->trans('depot.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
