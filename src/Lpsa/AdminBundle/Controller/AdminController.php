<?php

namespace Lpsa\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('LpsaAdminBundle:Admin:index.html.twig');
    }
}
