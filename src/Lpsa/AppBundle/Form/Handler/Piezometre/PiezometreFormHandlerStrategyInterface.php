<?php

namespace Lpsa\AppBundle\Form\Handler\Piezometre;

use Lpsa\AppBundle\Entity\Piezometre;
use Symfony\Component\HttpFoundation\Request;

interface PiezometreFormHandlerStrategyInterface {
    public function handleForm(Request $request, Piezometre $piezometre);
    public function createForm(Piezometre $piezometre);
    public function createView();
}
