<?php

namespace cinema\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="page_admin")
     */
    public function indexAction()
    {
        return $this->render('cinemaAdminBundle:Default:index.html.twig');
    }
}
