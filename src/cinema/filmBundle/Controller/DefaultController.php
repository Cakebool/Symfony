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
        $films = $this->getDoctrine()->getRepository('cinemafilmBundle:Film')->findAll();
        
        $titre_de_la_page = 'Films de la bibliothèque';
        
        return $this->render(
            'cinemafilmBundle:Film:list.html.twig',
            ['films' => $livres, 'titre' => $titre_de_la_page]
        );
    }
    
    /**
    * @Route("/film/{id}", requirements={"id": "\d+"})
    */
    public function showAction($id)
    {
        $film = $this->getDoctrine()->getRepository('cinemafilmBundle:Film')->find($id);
        
        return $this->render(
            'cinemafilmBundle:Film:show.html.twig',
            ['livre' => $livre]
        );
    }
}
