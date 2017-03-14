<?php

namespace Lpsa\AppBundle\Form\Handler\ExerciceUrgence;

use Lpsa\AppBundle\Entity\ExerciceUrgence;
use Symfony\Component\HttpFoundation\Request;

interface ExerciceUrgenceFormHandlerStrategyInterface {
    public function handleForm(Request $request, ExerciceUrgence $exerciceUrgence);
    public function createForm(ExerciceUrgence $exerciceUrgence);
    public function createView();
}
