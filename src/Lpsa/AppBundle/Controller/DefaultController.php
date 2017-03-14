<?php

namespace Lpsa\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LpsaAppBundle:Default:index.html.twig');
    }
}
