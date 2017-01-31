<?php

namespace cinema\filmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('cinemafilmBundle:Default:index.html.twig');
    }
    
    /**
    * @Route("/films")
    */
    public function listAction()
    {
        return $this->render('cinemafilmBundle:Default:list.html.twig');
    }
    
    /**
    * @Route("/film/{id}", requirements={"id": "\d+"})
    */
    public function showAction($id)
    {
        return $this->render('cinemafilmBundle:Default:show.html.twig');
    }
}
