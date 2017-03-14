<?php

namespace Lpsa\AppBundle\Form\Handler\DepotCategorie;

use Lpsa\AppBundle\Entity\DepotCategorie;
use Lpsa\AppBundle\Form\Type\DepotCategorie\DepotCategorieType;
use Symfony\Component\HttpFoundation\Request;

class NewDepotCategorieFormHandlerStrategy extends AbstractDepotCategorieFormHandlerStrategy{
    public function createForm(DepotCategorie $depotCategorie)
    {
        $this->form = $this->formFactory->create(new DepotCategorieType(), $depotCategorie, array(
            'action' => $this->router->generate('admin_depotcategorie_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, DepotCategorie $depotCategorie)
    {
        $this->depotCategorieManager->save($depotCategorie, true, true);

        return $this->translator->trans('depotcategorie.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
