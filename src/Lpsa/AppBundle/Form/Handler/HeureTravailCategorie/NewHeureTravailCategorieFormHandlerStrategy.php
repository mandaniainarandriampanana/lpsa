<?php

namespace Lpsa\AppBundle\Form\Handler\HeureTravailCategorie;

use Lpsa\AppBundle\Entity\HeureTravailCategorie;
use Lpsa\AppBundle\Form\Type\HeureTravailCategorie\HeureTravailCategorieType;
use Symfony\Component\HttpFoundation\Request;

class NewHeureTravailCategorieFormHandlerStrategy extends AbstractHeureTravailCategorieFormHandlerStrategy{
    public function createForm(HeureTravailCategorie $heureTravailCategorie)
    {
        $this->form = $this->formFactory->create(new HeureTravailCategorieType(), $heureTravailCategorie, array(
            'action' => $this->router->generate('heuretravailcategorie_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, HeureTravailCategorie $heureTravailCategorie)
    {
        $this->heureTravailCategorieManager->save($heureTravailCategorie, true, true);

        return $this->translator->trans('heuretravailcategorie.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}
