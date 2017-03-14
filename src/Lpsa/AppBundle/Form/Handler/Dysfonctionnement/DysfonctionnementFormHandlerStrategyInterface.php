<?php

namespace Lpsa\AppBundle\Form\Handler\Dysfonctionnement;

use Lpsa\AppBundle\Entity\Dysfonctionnement;
use Symfony\Component\HttpFoundation\Request;

interface DysfonctionnementFormHandlerStrategyInterface {
    public function handleForm(Request $request, Dysfonctionnement $dysfonctionnement);
    public function createForm(Dysfonctionnement $dysfonctionnement);
    public function createView();
}
