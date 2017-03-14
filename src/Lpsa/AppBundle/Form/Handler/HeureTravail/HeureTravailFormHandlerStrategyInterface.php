<?php

namespace Lpsa\AppBundle\Form\Handler\HeureTravail;

use Lpsa\AppBundle\Entity\HeureTravail;
use Symfony\Component\HttpFoundation\Request;

interface HeureTravailFormHandlerStrategyInterface {
    public function handleForm(Request $request, HeureTravail $heureTravail);
    public function createForm(HeureTravail $heureTravail);
    public function createView();
}
