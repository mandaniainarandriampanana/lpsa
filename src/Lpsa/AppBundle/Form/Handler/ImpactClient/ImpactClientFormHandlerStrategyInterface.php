<?php

namespace Lpsa\AppBundle\Form\Handler\ImpactClient;

use Lpsa\AppBundle\Entity\ImpactClient;
use Symfony\Component\HttpFoundation\Request;

interface ImpactClientFormHandlerStrategyInterface {
    public function handleForm(Request $request, ImpactClient $impactclient);
    public function createForm(ImpactClient $impactclient);
    public function createView();
}
