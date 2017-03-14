<?php

namespace Lpsa\AppBundle\Form\Handler\HeureTravailCategorie;

use Lpsa\AppBundle\Entity\HeureTravailCategorie;
use Symfony\Component\HttpFoundation\Request;

interface HeureTravailCategorieFormHandlerStrategyInterface {
    public function handleForm(Request $request, HeureTravailCategorie $heureTravailCategorie);
    public function createForm(HeureTravailCategorie $heureTravailCategorie);
    public function createView();
}
