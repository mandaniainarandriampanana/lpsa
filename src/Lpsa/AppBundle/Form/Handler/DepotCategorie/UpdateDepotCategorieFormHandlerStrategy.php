<?php

namespace Lpsa\AppBundle\Form\Handler\DepotCategorie;

use Lpsa\AppBundle\Entity\DepotCategorie;
use Lpsa\AppBundle\Form\Type\DepotCategorie\DepotCategorieType;
use Symfony\Component\HttpFoundation\Request;

class UpdateDepotCategorieFormHandlerStrategy extends AbstractDepotCategorieFormHandlerStrategy{
    
    public function createForm(DepotCategorie $depotCategorie)
    {
        $this->form = $this->formFactory->create(new DepotCategorieType(), $depotCategorie, array(
            'action' => $this->router->generate('admin_depotcategorie_edit',array('id' => $depotCategorie->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, DepotCategorie $depotCategorie)
    {

        $this->depotCategorieManager->save($depotCategorie, false, true);

        return $this->translator->trans('depotcategorie.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
