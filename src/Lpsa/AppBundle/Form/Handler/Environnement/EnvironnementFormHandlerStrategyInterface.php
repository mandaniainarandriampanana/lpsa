<?php

namespace Lpsa\AppBundle\Form\Handler\Environnement;

use Lpsa\AppBundle\Entity\Environnement;
use Symfony\Component\HttpFoundation\Request;

interface EnvironnementFormHandlerStrategyInterface {
    public function handleForm(Request $request, Environnement $environnement);
    public function createForm(Environnement $environnement);
    public function createView();
}
