<?php

namespace Lpsa\AppBundle\Form\Handler\ImpactMediatique;

use Lpsa\AppBundle\Entity\ImpactMediatique;
use Symfony\Component\HttpFoundation\Request;

interface ImpactMediatiqueFormHandlerStrategyInterface {
    public function handleForm(Request $request, ImpactMediatique $impactmediatique);
    public function createForm(ImpactMediatique $impactmediatique);
    public function createView();
}
