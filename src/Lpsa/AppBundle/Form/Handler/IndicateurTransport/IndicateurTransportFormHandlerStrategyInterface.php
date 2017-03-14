<?php

namespace Lpsa\AppBundle\Form\Handler\IndicateurTransport;

use Lpsa\AppBundle\Entity\IndicateurTransport;
use Symfony\Component\HttpFoundation\Request;

interface IndicateurTransportFormHandlerStrategyInterface {
    public function handleForm(Request $request, IndicateurTransport $indicateurTransport);
    public function createForm(IndicateurTransport $indicateurTransport);
    public function createView();
}
