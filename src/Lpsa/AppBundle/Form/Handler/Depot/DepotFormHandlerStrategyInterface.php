<?php

namespace Lpsa\AppBundle\Form\Handler\Depot;

use Lpsa\AppBundle\Entity\Depot;
use Symfony\Component\HttpFoundation\Request;

interface DepotFormHandlerStrategyInterface {
    public function handleForm(Request $request, Depot $depot);
    public function createForm(Depot $depot);
    public function createView();
}
