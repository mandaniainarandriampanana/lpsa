<?php

namespace Lpsa\AppBundle\Form\Handler\DepotCategorie;

use Lpsa\AppBundle\Entity\DepotCategorie;
use Symfony\Component\HttpFoundation\Request;

interface DepotCategorieFormHandlerStrategyInterface {
    public function handleForm(Request $request, DepotCategorie $depotCategorie);
    public function createForm(DepotCategorie $depotCategorie);
    public function createView();
}
